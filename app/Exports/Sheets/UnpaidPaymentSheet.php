<?php
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class UnpaidPaymentSheet implements FromArray, WithTitle, WithHeadings
{

    public function __construct()
    {
    }

    /**
     * @return Builder
     */
    public function array():array
    {
        $year = getdate(time())['year'];    //獲取當前年份
        $month = getdate(time())['mon'];    //獲取當前月份
        if($month>8) $current = $year+1;    //計算當前學年
        else $current = $year;
        $all = array();
        $pending = array();
        $add = array();
        $list = DB::table('payment')->where("year","=",$current)->get();
        foreach($list as $l){
            $student =  DB::table('student')->where("studentid","=",$l->studentid)->first();
            $dorm =  DB::table('dormitory')->where("dormitoryid","=",$student->dormitoryid)->first();
            if($student->status == "住宿"){
                if($l->status == "pending"){
                    $add = array(
                                "bid" => $dorm->buildingid,
                                "room" => $dorm->door_num,
                                "name" => $student->name,
                                "id" => $student->studentid,
                                "status" => $student->status,
                                "bill" => "欠费");
                    $pending[] = $add;
                }else if ($l->status != "pass"){
                    $add = array("bid" => "/",
                                "room" => "/",
                                "name" => $student->name,
                                "id" => $student->studentid,
                                "status" => $student->status,
                                "bill" => "已失效");
                }
                $all[] = $add;
            }
        }
        return $all;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return '未缴费情况';
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array{
        return ["楼栋", "寝室", "姓名", "学号", "状态", "缴费情况"];
    }
}
