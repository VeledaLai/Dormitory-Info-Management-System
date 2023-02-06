<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
class StudentExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(){

        $year = getdate(time())['year'];    //獲取當前年份
        $month = getdate(time())['mon'];    //獲取當前月份
        if($month>8) $current = $year+1;    //計算當前學年
        else $current = $year;

        return Student::select('studentid', 'name', 'gender', 'dormitoryid')
                        ->where('classes','=',$current)->orderby('dormitoryid')->get();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array{
        return ["学号", "学生姓名", "性别", "寝室号"];
    }

    // public function view(): View
    // {
    //     $year = getdate(time())['year'];    //獲取當前年份
    //     $month = getdate(time())['mon'];    //獲取當前月份
    //     if($month>8) $current = $year+1;    //計算當前學年
    //     else $current = $year;

    //     return view('freshman_admin', [
    //         'freshstds' => DB::table('student')
    //         ->leftJoin('dormitory','student.dormitoryid','=','dormitory.dormitoryid')
    //         ->select('student.studentid','student.name','student.gender','dormitory.buildingid','dormitory.door_num')
    //         ->where('student.classes','=',$current)
    //         ->get(),
    //         'check'=>1
    //     ]);
    // }
}
