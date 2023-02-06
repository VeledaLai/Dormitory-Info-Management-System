<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
//student import
use App\Imports\StudentsImport;
use App\Models\Dormitory;
use App\Models\Student;
use App\Models\CheckOut;
use App\Models\CheckIn;
use App\Models\AccessCard;
use App\Models\DormitoryRecord;
use App\Models\Manager;

//student export
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentExport;

//学生分配宿舍
use App\Assign\AssignDormitory;
use App\Models\Payment;

class AdminController extends Controller
{
    /**
     * 显示给定用户的个人资料。
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function index(Request $request){
        return view("/admin/committee_admin");
    }
    //新生入住
    public function freshman(Request $request){
        if(session()->has('failmsg'))
            $check = session()->get('failmsg');
        else $check = null;
        $year = getdate(time())['year'];    //獲取當前年份
        $month = getdate(time())['mon'];    //獲取當前月份
        if($month>8) $current = $year+1;    //計算當前學年
        else $current = $year;
        $freshstds = DB::table('student')
                     ->leftJoin('dormitory','student.dormitoryid','=','dormitory.dormitoryid')
                     ->select('student.studentid','student.name','student.gender','dormitory.buildingid','dormitory.door_num')
                     ->where('student.classes','=',$current)
                     ->get();
        return view("/admin/freshman_admin")->with(['freshstds'=>$freshstds, 'check'=>$check, 'year'=>$current]);
    }
    //导入入住学生名单
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request){
        //导入
        $validator = Validator::make(
            [
                'file'      => $request->file,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file'          => 'required',
                'extension'      => 'required|in:xlsx,xls',
            ]
        );
        if ($validator->fails()) {
            return redirect('/admin/freshman')->with(["failmsg"=>"档案格式不正确，请重新选择"]);
        }
        //取得档案路径
        $file = $request->file('file');
        if(substr(strtolower(PHP_OS), 0 ,3) == 'win') $path = $file->getRealPath();
        else $path = storage_path('app').'/'.$file->store('temp');
        //导入新生的xml到数据库
        Excel::import(new StudentsImport, $path);

        if(!session()->has('failmsg')){
            $failmsg = "新生导入成功，";
            session()->put('failmsg',$failmsg);
        }else{
            $failmsg = session()->get('failmsg')."学号重复，请检查后重新导入;";
            session()->put('failmsg',$failmsg);
        }

        $year = getdate(time())['year'];    //獲取當前年份
        $month = getdate(time())['mon'];    //獲取當前月份
        if($month>8) $current = $year+1;    //計算當前學年
        else $current = $year;
        //分配宿舍
        //分配男新生宿舍
        $assigns=Student::where('dormitoryid', null)->where('classes', $current)->where('status','住宿')->where('gender','M')->get();
        foreach($assigns as $assign){
            $this->assign($assign,'M');
        }
        //分配女新生宿舍
        $assigns=Student::where('dormitoryid', null)->where('classes', $current)->where('status','住宿')->where('gender','F')->get();
        foreach($assigns as $assign){
            $this->assign($assign,'F');
        }

        //取得信息
        $failmsg = session()->get('failmsg')."宿舍分配结束。";
        session()->put('failmsg', $failmsg);
        return redirect()->back();
    }
    //导出新生宿舍名单
    public function freshmanexport(){
        return Excel::download(new StudentExport, '新生宿舍分配名单.xlsx');
    }

    //分配宿舍
    private function assign(Student $a, String $gender){
        //找出未满员的宿舍
        $check = DormitoryRecord::where('remaining_beds', '>', 0)->get();
        foreach($check as $c){
            $check_gender = Student::where('dormitoryid',$c->dormitoryid)->first();
            //取不到学生，该宿舍为空宿舍
            if($check_gender == null) {
                $check = DormitoryRecord::find($c->dormitoryid);
                $check_gender = "checked";
                break;
            }elseif($check_gender->gender==$gender){    //住在该宿舍的学生性别一致
                $check = DormitoryRecord::find($c->dormitoryid);
                $check_gender = "checked";
                break;
            }
            $check_gender = "unchecked";
        }
        //有可分配的宿舍
        if($check_gender == "checked"){
            //取宿舍楼栋号
            $bid = $check->dormitory->buildingid;
            //分配该学生到该宿舍
            //更改学生信息
            $a->dormitoryid = $check->dormitoryid;
            $a->status = '住宿';
            $a->save();

            //更改宿舍记录信息
            $check->remaining_beds = $check->remaining_beds-1;
            $check->save();

            //创建未激活的门禁卡
            $card = new AccessCard();
            $card->studentid = $a->studentid;
            $card->buildingid = $bid;
            $card->status = 0;
            $card->save();

            $year = getdate(time())['year'];    //獲取當前年份
            $month = getdate(time())['mon'];    //獲取當前月份
            if($month>8) $current = $year+1;    //計算當前學年
            else $current = $year;
            $payment = Payment::where("studentid","=",$a->studentid)->where("year","=",$current)->first();
            if($payment == null){
                //创建住宿费账单
                $payment = new Payment();
                $payment->studentid = $a->studentid;
                $payment->year = $current;
                $payment->status = 'pending';
                $payment->save();
            }else{
                $payment = Payment::where("studentid","=",$a->studentid)->where("year","=",$current)
                                    ->update(['status' => 'pending']);
            }
            //创建入住宿舍记录
            //新生无需审核
            if($a->classes == $current){
                $cin = new CheckIn();
                $cin->status = 'pass';
                $cin->studentid = $a->studentid;
                $cin->save();
            }else{
                $cin = CheckIn::find($a->studentid)->update(['status' => 'pass']);
            }
            return $this;
        }else{
            //无可分配的宿舍，写入失败信息
            if(!session()->has('failmsg')){
                session()->put('failmsg', "宿舍数量不足，无法继续分配。");
            }else{
                $failmsg = session()->get('failmsg');
                session()->put('failmsg', $failmsg."宿舍数量不足，无法继续分配。");
            }
            return $this;
        }
    }

    //入住申請頁面
    public function checkin(Request $request){
        if($request->check == null)$check = 0;
        $list = DB::table('check_in')->where("status","=","pending")->get();
        $apply = array();
        foreach($list as $l){
            // $applicant = DB::table('student')->where("studentid","=",$l->studentid)->first();
            $applicant = Student::find($l->studentid);
            $apply[] = $applicant;
        }
        return view("/admin/checkin_admin")->with(["apply"=>$apply, "check"=>$check]);
    }
    //入住申請審批
    public function checkin_submit(Request $request){
        if($request->check == null)$check = 0;
        if(is_null($request->select)) return redirect()->back();
        if($request->operation == "agree"){
            foreach($request->select as $s){
                //取得申请学生
                $assign = Student::find($s);
                //为申请学生分配宿舍
                $this->assign($assign,$assign->gender);
                //取得信息
                $failmsg = session()->get('failmsg');
                //成功分配。刪除以前的checkout紀錄(否則該住宿生無法申請退宿)
                if($failmsg == null) DB::table('check_out')->where("studentid","=",$s)->delete();
            }
        }else{//拒絕該申請後，刪除該條checkin紀錄(否則該生無法再申請入住)
            foreach($request->select as $s)
                DB::table('check_in')->where("studentid","=",$s)->delete();
        }
        //顯示更新的待審批名單
        $list = DB::table('check_in')->where("status","=","pending")->get();
        $apply = array();
        foreach($list as $l){
            $applicant = DB::table('student')->where("studentid","=",$l->studentid)->first();
            $apply[] = $applicant;
        }
        return view("/admin/checkin_admin")->with(["apply"=>$apply, "check"=>$check]);
    }

    //退宿申請頁面
    public function checkout(){
        $list = DB::table('check_out')->where("status","=","pending")->get();
        $apply = array();
        foreach($list as $l){
            $applicant = DB::table('student')->where("studentid","=",$l->studentid)->first();
            $add = array("name" => $applicant->name,
                         "id" => $applicant->studentid,
                         "class" => $applicant->classes,
                         "did" => $applicant->dormitoryid,
                         "reason" => $l->reason);
            $apply[] = $add;
        }
        return view("/admin/checkout_admin")->with(["apply"=>$apply]);
    }
    //退宿申請審批
    public function checkout_submit(Request $request){
        if(is_null($request->select)) return redirect()->back();
        $year = getdate(time())['year'];    //獲取當前年份
        $month = getdate(time())['mon'];    //獲取當前月份
        if($month>8) $current = $year+1;    //計算當前學年
        else $current = $year;
        if($request->operation == "agree"){
            foreach($request->select as $s){
                $reason = DB::table('check_out')->where("studentid","=",$s)->value('reason');
                if($reason == "毕业"){
                    DB::table('late')->where("studentid","=",$s)->delete();
                    DB::table('leave_return')->where("studentid","=",$s)->delete();
                    DB::table('check_out')->where("studentid","=",$s)->update(['status'=>"pass"]);
                    DB::table('access_card')->where("studentid","=",$s)->delete();
                    $did = Student::find($s)->dormitoryid;
                    DB::table('dormitory_records')->where("dormitoryid","=",$did)->update(['remaining_beds'=>DB::raw('remaining_beds+1')]);
                    DB::table('student')->where("studentid","=",$s)->update(["dormitoryid"=>null, "status"=>$reason]);

                    $p = Payment::where('year',$current)->where('studentid',$s)->first();
                    if($p->status == "pending"){
                        DB::table('payment')->where('year',$current)->where('studentid',$s)
                                            ->update([
                                                'status'    =>  'fail'
                                            ]);
                    }
                }else{
                    DB::table('check_out')->where("studentid","=",$s)->update(['status'=>"pass"]);
                    DB::table('check_in')->where("studentid","=",$s)->delete();
                    DB::table('access_card')->where("studentid","=",$s)->delete();
                    $did = Student::find($s)->dormitoryid;
                    DB::table('dormitory_records')->where("dormitoryid","=",$did)->update(['remaining_beds'=>DB::raw('remaining_beds+1')]);
                    DB::table('student')->where("studentid","=",$s)->update(["dormitoryid"=>null, "status"=>$reason]);
                    $p = Payment::where('year',$current)->where('studentid',$s)->first();
                    if($p->status == "pending"){
                        DB::table('payment')->where('year',$current)->where('studentid',$s)
                                            ->update([
                                                'status'    =>  'fail'
                                            ]);
                    }
                }
            }

            $check = 1;
        }else{
                foreach($request->select as $s)
                    DB::table('check_out')->where("studentid","=",$s)->delete();
            $check = 2;
        }
        return redirect()->route('checkout')->with(["check"=>$check]);
    }
    //寢室調動頁面
    public function change(Request $request){
        if($request->exist == null)$exist=false;
        if($request->check == null)$check = 0;
        return view("/admin/change_admin")->with(["exist"=>$exist, "check"=>$check]);
    }
    //寢室調動＿判斷(1.學號是否存在 2.一般住宿生：可修改 正申請退宿的住宿生,非住宿生：不可修改)
    public function change_find(Request $request){
        if($request->check == null)$check = 0;
        $id = $request->id;
        $exist = !(DB::table('student')->where("studentid","=",$id)->get()->isEmpty());
        if($exist){
            $student = Student::find($id);
            $status = $student->status;
            if($status == "住宿"){
                $dormitory = Dormitory::find($student->dormitoryid);
                $checkout = CheckOut::find($id);
                if($checkout!=null && $checkout->status=="pending")
                    $status = "申请退宿";
            }else $dormitory = null;
        }else{
             $student = null;
             $dormitory = null;
             $status = null;
             $check = 3;
        }
        return view("/admin/change_admin")->with(["exist"=>$exist, "check"=>$check, "student"=>$student, "dormitory"=>$dormitory, "status"=>$status]);
    }
    //寢室調動操作(同時判斷輸入的寢室是否存在)
    public function change_submit(Request $request){
        if($request->exist == null)$exist=false;
        $check = 0;
        $id = $request->id;
        $new_bid = $request->new_bid;
        $new_room = $request->new_room;
        //新宿舍的信息
        $dormitory = Dormitory::find($new_bid.$new_room);
        if(!is_null($dormitory)){
            //检查新宿舍的床位
            $record = DormitoryRecord::find($dormitory->dormitoryid);
            if(!is_null($record) && $record->remaining_beds > 0){        //新宿舍存在且有空床位
                //查看新宿舍的学生性别
                $gender = Student::where('dormitoryid',$dormitory->dormitoryid)->first();
                //与申请者同性别
                if($gender == (Student::find($id)->gender) || ($record->remaining_beds > 0 && $record->remaining_beds <= 5)){
                    //旧宿舍号
                    $did = Student::find($id)->dormitoryid;
                    //旧宿舍的床位数量+1
                    DB::table('dormitory_records')->where("dormitoryid","=",$did)->update(['remaining_beds'=>DB::raw('remaining_beds+1')]);
                    $check = DB::table('student')->where("studentid","=",$id)
                                                ->update(['dormitoryid' => $dormitory->dormitoryid]);
                    //新宿舍的床位-1
                    DB::table('dormitory_records')->where("dormitoryid","=",$dormitory->dormitoryid)
                                                ->update([
                                                        'remaining_beds'=>DB::raw('remaining_beds-1')
                                                    ]);
                    $check = DB::table('access_card')->where("studentid","=",$id)
                                                    ->update(['buildingid' => $new_bid]);
                }else $check = 4;    //性别冲突
            }else $check = 5;   //床位已满
        }else $check = 2;    //宿舍不存在
        return view("/admin/change_admin")->with(["exist"=>$exist, "check"=>$check]);
    }
    //繳費信息
    public function payment(Request $request){
        if($request->cookie('check') == null)$check = 0;
        else $check = $request->cookie('check');
        $make_fail=false;
        $year = getdate(time())['year'];    //獲取當前年份
        $month = getdate(time())['mon'];    //獲取當前月份
        if($month>8) $current = $year+1;    //計算當前學年
        else{
            $current = $year;
            $fail = DB::table('payment')->where("year","=",$current)->where("status","=","pending")->get();
            if($fail != [])$make_fail=true;
        }
        $old_student=DB::table('student')->where("classes","<",$current)->get();
        $inform=false;
        foreach($old_student as $o){
            $old_list=DB::table('payment')->where("studentid","=",$o->studentid)->where("year","=",$current)->first();
            if(is_null($old_list))
                $inform=true;
        }
        $all = array();
        $pending = array();
        $pass = array();
        $list = DB::table('payment')->where("year","=",$current)->get();
        foreach($list as $l){
            $student =  DB::table('student')->where("studentid","=",$l->studentid)->first();
            $dorm =  DB::table('dormitory')->where("dormitoryid","=",$student->dormitoryid)->first();
            if($student->status == "住宿"){
                if($l->status == "pending"){
                    $add = array("name" => $student->name,
                                "id" => $student->studentid,
                                "bid" => $dorm->buildingid,
                                "room" => $dorm->door_num,
                                "status" => $student->status,
                                "bill" => "欠费");
                    $pending[] = $add;
                }else if ($l->status == "pass"){
                    $add = array("name" => $student->name,
                                "id" => $student->studentid,
                                "bid" => $dorm->buildingid,
                                "room" => $dorm->door_num,
                                "status" => $student->status,
                                "bill" => "已缴清");
                    $pass[] = $add;
                }else{
                    $add = array("name" => $student->name,
                                "id" => $student->studentid,
                                "bid" => "/",
                                "room" => "/",
                                "status" => $student->status,
                                "bill" => "已失效");
                }
                $all[] = $add;
            }
        }
        return view("/admin/payment_admin")->with(["current"=>$current, "make_fail"=>$make_fail, "inform"=>$inform, "all"=>$all, "pending"=>$pending, "pass"=>$pass, "check"=>$check]);
    }
    public function payment_renew(Request $request){
        if($request->cookie('check') == null)$check = 0;
        else $check = $request->cookie('check');
        $year = getdate(time())['year'];    //獲取當前年份
        $month = getdate(time())['mon'];    //獲取當前月份
        if($month>8) $current = $year+1;    //計算當前學年
        else $current = $year;
        $student = DB::table('student')->where("status","=","住宿")->get(); //發起繳費通知
        foreach($student as $s){
            if(DB::table('payment')->where("studentid","=",$s->studentid)->where("year","=",$current)->get()->isEmpty()){
                DB::table('payment')->insert(["studentid"=>$s->studentid, "year"=>$current, "status"=>"pending"]);
                DB::table('access_card')->where("studentid","=",$s->studentid)->update(["status"=>0]);
            }
            if($month<8 && $month>1){//下半學年仍欠費則失效
                $fail = DB::table('payment')->where("year","=",$current)->where("status","=","pending")->get();
                foreach($fail as $f){
                    DB::table('payment')->where("studentid","=",$f->studentid)->where("status","=","pending")->update(["status"=>"fail"]);
                    DB::table('access_card')->where("studentid","=",$f->studentid)->delete();
                    DB::table('check_in')->where("studentid","=",$f->studentid)->delete();
                    DB::table('student')->where("studentid","=",$f->studentid)->update(["dormitoryid"=>null, "status"=>"失效"]);
                }
            }
        }
        $check = 1;
        return redirect()->route('payment')->cookie("check",$check,1);
    }
    public function payment_download(Request $request){

    }

    //樓棟管理頁面
    public function building(Request $request){
        if($request->check == null)$check = 0;
        $building =  DB::table('manager')->get();
        return view("/admin/building_admin")->with(["building"=>$building, "check"=>$check]);
    }
    //新增樓棟
    public function add_building(Request $request){
        if($request->check == null)$check = 0;
        $bid =  $request->bid;
        $pwd = $request->pwd;
        $year = getdate(time())['year'];    //獲取當前年份
        $month = getdate(time())['mon'];    //獲取當前月份
        if($month>8) $current = $year+1;    //計算當前學年
        else $current = $year;
        if(!Manager::find($bid)){
            DB::table('manager')->insert(['buildingid'=>$bid, 'pwd'=>Hash::make($pwd)]);
        for($floor = 2; $floor < 10; $floor++)
            for($room = 1;$room < 26; $room++){
                $num = $floor*100+$room;
                $did = $bid.$num;
                DB::table('dormitory')->insert(['dormitoryid'=>$did, 'buildingid'=>$bid, 'door_num'=>$num, 'bed_num'=>5]);
                DB::table('utility_bill')->insert(['year'=>$current, 'month'=>$month, 'dormitoryid'=>$did, 'electricfee'=>0, 'waterfee'=>0, 'status'=>"pass"]);
                $dormitory = Dormitory::where('dormitoryid',$did)->first();
                $record = new DormitoryRecord([
                    'dormitoryid' =>    $dormitory->dormitoryid,
                    'remaining_beds'    =>  $dormitory->bed_num,
                ]);
                $record->save();
                $check += 1;
            }
        }
        else{
                $check=DB::table('manager')->where("buildingid","=",$bid)->update(['pwd'=>Hash::make($pwd)]);
        }
        $building =  DB::table('manager')->get();
        return view("/admin/building_admin")->with(["building"=>$building, "check"=>$check]);
    }
}
