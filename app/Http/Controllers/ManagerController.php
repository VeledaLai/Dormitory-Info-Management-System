<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Dormitory;
use App\Models\Student;
use App\Models\UtilityBill;
use App\Models\Maintain;
use App\Models\Late;
use Dotenv\Parser\Value;

class  ManagerController extends Controller
{
    /**
     * 显示给定用户的个人资料。
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function index(){
        $user = session()->get('user', 'default');
        return view("/manager/home_manager")->with(["user"=>$user]);
    }

    //宿舍信息管理
    public function info(){
        $check = 0;
        return view("/manager/info_manager")->with(["check"=>$check]);
    }
    public function info_submit(Request $request){
        $user = session()->get('user', 'default');
        $did = $user->buildingid.$request->did;
        $students = Student::where("dormitoryid",$did)->get();
        if(!$students->isEmpty()) $check = 1;
        else $check = 2;
        return view("/manager/info_manager")->with(["check"=>$check, "students"=>$students]);
    }

    //宿舍水电管理
    public function fee(){
        $year = getdate(time())['year'];    //獲取當前年份
        $month = getdate(time())['mon'];    //獲取當前月份
        if($month>8) $current = $year+1;    //計算當前學年
        else $current = $year;
        $user = session()->get('user', 'default');
        $all = UtilityBill::where("dormitoryid","like",$user->buildingid."%")->where("year",$current)->where("month",$month)->get();
        $paid = UtilityBill::where("dormitoryid","like",$user->buildingid."%")->where("year",$current)->where("month",$month)->where("status","pass")->get();
        $unpaid = UtilityBill::where("dormitoryid","like",$user->buildingid."%")->where("year",$current)->where("month",$month)->where("status","pending")->get();
        return view("/manager/fees_manager")->with(["all"=>$all,"paid"=>$paid,"unpaid"=>$unpaid]);
    }
    public function fee_submit(Request $request){
        $user = session()->get('user', 'default');
        $did = $user->buildingid.$request->did;
        $std = Student::where("dormitoryid",$did)->orderBy("classes")->first();
        if($std != null){
            $all = DB::table("utility_bill")->where("dormitoryid",$did)->where("year",">=",$std->classes)->get();
            $paid = DB::table("utility_bill")->where("dormitoryid",$did)->where("year",">=",$std->classes)->where("status","pass")->get();
            if($paid->isEmpty()) $paid = null;
            $unpaid = DB::table("utility_bill")->where("dormitoryid",$did)->where("year",">=",$std->classes)->where("status","pending")->get();
            if($unpaid->isEmpty()) $paid = null;
        }else{
            $all = null;
            $paid = null;
            $unpaid = null;
        }
        return view("/manager/fees_manager")->with(["all"=>$all,"paid"=>$paid,"unpaid"=>$unpaid]);
    }

    //宿舍报修管理
    public function maintain(){
        $user = session()->get('user', 'default');
        $lists = DB::table("maintain")->where("dormitoryid","like",$user->buildingid."%")->where("ctime",null)->get();
        if($lists->isEmpty()) $lists = null;
        return view("/manager/maintain_manager")->with(["lists"=>$lists]);
    }
    public function maintain_submit(Request $request){
        $user = session()->get('user', 'default');
        $did = $user->buildingid.$request->did;
        $lists = Maintain::where("dormitoryid",$did)->get();
        if($lists->isEmpty()) $lists = null;
        return view("/manager/maintain_manager")->with(["lists"=>$lists]);
    }

    //夜归管理
    public function late(){
        $std = null;
        return view("/manager/late_manager")->with(["std"=>$std,"check"=>2]);
    }
    public function late_find(Request $request){
        $user = session()->get('user', 'default');
        $sid = $request->sid;
        $std = Student::where("studentid",$sid)->where("dormitoryid","like",$user->buildingid."%")->first();
        $date = date("Y-m-d H:m:s");
        if(is_null($std)) $check = 0;
        else $check = 1;
        return view("/manager/late_manager")->with(["std"=>$std, "date"=>$date,"check"=>$check]);
    }
    public function late_submit(Request $request){
        $sid = $request->sid;
        $reason = $request->reason;
        $datetime = date("Y-m-d H:i:s");

        $late = new Late();
        $late->studentid = $sid;
        $late->reason = $reason;
        $late->recordtime = $datetime;
        $late->save();


        return redirect()->route("late_manager")->with(["check"=>3]);
    }
}
