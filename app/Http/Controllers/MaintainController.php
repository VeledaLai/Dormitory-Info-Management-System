<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use lluminate\Database\Eloquent\Collection;
//student import
use App\Models\Dormitory;
use App\Models\Manager;

class MaintainController extends Controller
{
    /**
     * 显示给定用户的个人资料。
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function index(Request $request){
        return view("/maintain/home_maintain");
    }
    //報修項目管理
    public function repair(Request $request){
        if($request->cookie('check') == null)$check = 0;
        else $check = $request->cookie('check');
        $bid = $request->bid;
        $did = $request->did;
        $exist = DB::table('dormitory')->where("dormitoryid","=",$bid.$did)->first();
        //待完成項目
        if($exist != null)
            $list = DB::table('maintain')->where("dormitoryid","=",$bid.$did)->whereNull("ctime")->orderBy('id', 'asc')->get();
        else
            $list = DB::table('maintain')->whereNull("ctime")->orderBy('id', 'asc')->get();
        $item = array();
        foreach($list as $l){
            $dorm = Dormitory::find($l->dormitoryid);
            $add = array("id" => $l->id,
                         "bid" => $dorm->buildingid,
                         "room" => $dorm->door_num,
                         "applytime" => $l->applytime,
                         "goodsname" => $l->goodsname,
                         "reason" => $l->reason,
                         "phone" => $l->phone);
            $item[] = $add;
        }
        //已完成項目
        if($exist != null)
            $list = DB::table('maintain')->where("dormitoryid","=",$bid.$did)->whereNotNull("ctime")->orderBy('id', 'asc')->get();
        else
            $list = DB::table('maintain')->whereNotNull("ctime")->orderBy('id', 'asc')->get();
        $record = array();
        foreach($list as $l){
            $dorm = Dormitory::find($l->dormitoryid);
            $add = array("bid" => $dorm->buildingid,
                         "room" => $dorm->door_num,
                         "ctime" => $l->ctime,
                         "goodsname" => $l->goodsname,
                         "phone" => $l->phone);
            $record[] = $add;
        }
        if($exist != null && $bid != null && $did != null)
            $check = 1;
        if($exist == null && $bid != null && $did != null)
            $check = 3;
        return view("/maintain/repair_maintain")->with(["item"=>$item, "record"=>$record, "check"=>$check]);
    }
    public function repair_submit(Request $request){
        if(is_null($request->select)) return redirect()->back();
        if($request->check == null)$check = 0;
        if($request->operation == "done"){
            $renew = 0;
            $count = 0;
            $ctime = date("Y-m-d h:i:s");
            foreach($request->select as $s){
                $count ++;
                $renew += DB::table('maintain')->where("id", "=", $s)->update(["ctime"=>$ctime]);
            }
            if($renew=$count)
                $check = 2;
        }
        return redirect()->route('repair')->cookie("check",$check,1);
    }
    //水電費管理
    public function fee(Request $request){
        if($request->cookie('check') == null)$check = 0;
        else $check = $request->cookie('check');
        $year = getdate(time())['year'];    //獲取當前年份
        $month = getdate(time())['mon'];    //獲取當前月份
        if($month>8) $current = $year+1;    //計算當前學年
        else $current = $year;
        $current_fee = DB::table('utility_bill')->where("year", "=", $current)
                                                ->where("month", "=", $month)
                                                ->first();
        if($current_fee == null) $exist = false;
        else $exist = true;
        $building = Manager::all();
        if($request->bid == null)$bid = "T1";
        else $bid = $request->bid;
        $did = Dormitory::where("buildingid", "=", $bid)->get();
        $record = array();
        foreach($did as $d){
            $fee = DB::table('utility_bill')->where("year", "=", $current)
                                            ->where("month", "=", $month)
                                            ->where("dormitoryid", "=", $d->dormitoryid)
                                            ->first();
            if(is_null($fee))$exist = false;
            else{
            if($fee->status == "pass")$status="已缴清";
            else $status="欠费";
            $add = array("did" => $d->dormitoryid,
                         "water" => $fee->waterfee,
                         "electric" => $fee->electricfee,
                         "status" => $status);
            $record[]=$add;
            }
        }
        return view("/maintain/fee_maintain")->with(["bid_selected"=>$bid,"building"=>$building, "month"=>$month, "year"=>$current, "record"=>$record, "exist"=>$exist, "check"=>$check]);
    }
    public function fee_submit(Request $request){
        if($request->check == null)$check = 0;
        $year = getdate(time())['year'];    //獲取當前年份
        $month = getdate(time())['mon'];    //獲取當前月份
        if($month>8) $current = $year+1;    //計算當前學年
        else $current = $year;
        $count = 0;
        $renew = 0;
        $dorm = Dormitory::all();
        foreach($dorm as $d){
            $fee = DB::table('utility_bill')->where("year", "=", $current)
                                            ->where("month", "=", $month)
                                            ->where("dormitoryid", "=", $d->dormitoryid)
                                            ->first();
            if(is_null($fee)){
            $count ++;
            $renew += DB::table('utility_bill')->insert(['year'=>$current, 'month'=>$month, 'dormitoryid'=>$d->dormitoryid, 'electricfee'=>rand(50,200), 'waterfee'=>rand(25,50), 'status'=>"pending"]);
            }
        }
        if($renew == $count)
            $check = 1;
        return redirect()->route('fee')->cookie("check",$check,1);
    }
}
