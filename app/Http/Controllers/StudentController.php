<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Dormitory;
use Illuminate\Http\Request;
use lluminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class StudentController extends Controller
{
    /**
     * 显示给定用户的个人资料。
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function index(){
        $user = session()->get('user', 'default');
        $dormitory = DB::table('dormitory')->where("dormitoryid","=",$user->dormitoryid)->first();
        return view("/student/homepage")->with(["user"=>$user,"dormitory"=>$dormitory]);
    }
    //報修頁面
    public function repair(Request $request){
        $user = $request->session()->get('user', 'default');
        $dormitory = DB::table('dormitory')->where("dormitoryid","=",$user->dormitoryid)->first();
        if($request->check == null)$check = 0;
        return view("/student/repair")->with(["user"=>$user, "dormitory"=>$dormitory, "check"=>$check]);
    }
    //報修操作
    public function repair_submit(Request $request){
        $user = $request->session()->get('user', 'default');
        $dormitory = DB::table('dormitory')->where("dormitoryid","=",$user->dormitoryid)->first();
        $goodsname = $request->repair;
        $reason = $request->reason;
        $applytime = date("Y-m-d H:i:s");
        $phone = $request->phone;
        $id = DB::table("maintain")->insertGetId(
            ['dormitoryid'=>$dormitory->dormitoryid,
             'goodsname'=>$goodsname, 'reason'=>$reason,
             'applytime'=>$applytime, 'phone'=>$phone]
        );
        $data = DB::table('maintain')->where('id', "=", $id)->get();
        if(!$data->isEmpty()) $check = 1;
        else $check = 0;
        return view("/student/repair")->with(["user"=>$user,"dormitory"=>$dormitory, "check"=>$check]);
    }

    //住宿費繳納頁面
    public function payment(Request $request){
        $user = $request->session()->get('user', 'default');
        $check = 0;
        $record = DB::table('payment')->where("studentid","=",$user->studentid)
                                      ->orderBy('year','desc')
                                      ->get();
        if($record == [])   $bill = null;
        else $bill = $record->first();
        $amount = 1800;
        return view("/student/payment")->with(["user"=>$user, "bill"=>$bill, "record"=>$record, "amount"=>$amount, "check"=>$check]);
    }
    //住宿費繳納操作
    public function pay(Request $request){
        $user = $request->session()->get('user', 'default');
        //修改繳納紀錄
        $check = DB::table('payment')->where("studentid","=",$user->studentid)
                                     ->where("status","=","pending")
                                     ->update(['status' => 'pass']);
        //激活門禁卡
        $check += DB::table('access_card')->where("studentid","=",$user->studentid)
                                          ->update(['status' => 1]);
        //顯示新的繳費記錄
        $record = DB::table('payment')->where("studentid","=",$user->studentid)
                                      ->orderBy('year','desc')
                                      ->get();
        $bill = $record->first();
        $amount = 1800;
        return view("/student/payment")->with(["user"=>$user, "bill"=>$bill, "record"=>$record, "amount"=>$amount, "check"=>$check]);
    }

    //離校返校登記頁面
    public function leave_return(Request $request){
        $check = 0;
        $user = $request->session()->get('user', 'default');
        $record = DB::table('leave_return')
                            ->where('studentid',"=",$user->studentid)
                            ->whereNull('returntime')
                            ->get();
        if($record->isEmpty())
            $operation = true;
        else
            $operation = false;
        return view("/student/leave_return")->with(["operation"=>$operation, "check"=>$check]);
    }
    //離校返校登記操作
    public function leave_return_record(Request $request){
        $user = $request->session()->get('user', 'default');
        $operation = $request->operation;
        if($operation){
            $leaveday = $request->input("leaveday");

            $id = DB::table('leave_return')->insertGetId(['studentid' => $user->studentid, 'leavetime' => $leaveday]);
            $data = DB::table('leave_return')->where('id', "=", $id)->get();
            if(!$data->isEmpty())$check = 1;
            else $check = 0;
        }
        else{
            $returnday = $request->input("returnday");
            $check = DB::table('leave_return')
                    ->where('studentid',"=",$user->studentid)
                    ->whereNull('returntime')
                    ->update(['returntime' => $returnday]);
        }
        return redirect()->route('leave_return')->with(["check"=>$check]);
    }
    //夜歸紀錄頁面
    public function late(Request $request){
        $user = $request->session()->get('user', 'default');
        $count_late = 0;
        $records = DB::table("late")->where("studentid","=",$user->studentid)->get();
        if(!$records->isEmpty())
            $count_late = DB::table("late")->where("studentid","=",$user->studentid)->where('recordtime','like',date('Y-m'."%"))->count();
        return view("/student/late")->with(["records"=>$records, "count"=>$count_late]);
    }
    //显示水电费页面
    public function fee(Request $request){
        //get login user
        $user = $request->session()->get('user', 'default');
        $dormitory = DB::table('dormitory')->where("dormitoryid","=",$user->dormitoryid)->first();
        if($dormitory != null){
            //get all fees record
            $fees = DB::table('utility_bill')->where("dormitoryid","=",$dormitory->dormitoryid)
                                             ->get();
            //get amount of unpaid fees
            $amount = DB::table('utility_bill')->where("dormitoryid","=",$dormitory->dormitoryid)
                                               ->select(DB::raw('Sum(electricfee) as efees, Sum(waterfee) as wfees'))
                                               ->where("status","=","pending")
                                               ->get();
            $amount = $amount[0]->efees + $amount[0]->wfees;
        }else{
            $fees=null;
            $amount="N/A";
        }
        if($request->check == null) $check = 0;
        return view("/student/fee")->with(["user"=>$user,"dormitory"=>$dormitory,"fees"=>$fees,"amount"=>$amount,"check"=>$check]);
    }
    //缴纳水电费
    public function fee_submit(Request $request){
        $user = $request->session()->get('user', 'default');
        $dormitory = DB::table('dormitory')->where("dormitoryid","=",$user->dormitoryid)->first();
        //check if update success
        $check = DB::table('utility_bill')->where("dormitoryid","=",$dormitory->dormitoryid)
                                            ->where("status","=","pending")
                                            ->update(["status"=>"pass"]);
        $fees = DB::table('utility_bill')->where("dormitoryid","=",$dormitory->dormitoryid)
                                            ->get();
        //all fees were paid
        $amount = 0;
        return view("/student/fee")->with(["user"=>$user,"dormitory"=>$dormitory,"check"=>$check,"fees"=>$fees,"amount"=>$amount]);
    }
    //寢室信息頁面
    public function dormitory(Request $request){
        $user = $request->session()->get('user', 'default');
        $dormitory = Dormitory::find($user->dormitoryid);
        return view("/student/dormitory")->with(["user"=>$user,"dormitory"=>$dormitory]);
    }
    //入退宿申請頁面
    public function check_in_out(Request $request){
        if($request->check == null)$check = 0;
        if($request->continue == null)$continue = 0;
        $user = $request->session()->get('user', 'default');
        return view("/student/check_in_out")->with(["user"=>$user, "check"=>$check, "continue"=>$continue]);
    }
    //入退宿申請操作
    public function check_in_out_apply(Request $request){
        $user = $request->session()->get('user', 'default');
        $check = 0;
        $id = $request->input("id");
        $pwd = $request->input("pwd");
        if(($id == $user->studentid) && Hash::check($pwd, $user->pwd)){
            $continue = 1;
            if( $user->status == "住宿" ){
                $reason = $request->input("reason");
                $buildingid = DB::table('dormitory')->where("dormitoryid","=",$user->dormitoryid)->value('buildingid');
                // 建立check_out紀錄
                if(DB::table('check_out')->where("studentid","=",$user->studentid)->get()->isEmpty()) //沒申請過退宿
                    $check = DB::table('check_out')
                            ->insert(['studentid' => $user->studentid, 'buildingid' => $buildingid, 'reason' => $reason, 'status' => "pending"]);
                else //重複申請退宿
                    $check = 2;
            }
            else{
                //建立check_in紀錄
                if(DB::table('check_in')->where("studentid","=",$user->studentid)->get()->isEmpty()) //沒申請過入住
                    $check = DB::table('check_in')
                                ->insert(['studentid' => $user->studentid, 'status' => "pending"]);
                else //重複申請入住
                    $check = 2;
            }
        }else $continue = 2;

        return view('/student/check_in_out')->with(["user"=>$user,"check"=>$check, "continue"=>$continue]);
    }
}
