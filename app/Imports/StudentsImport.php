<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\CheckIn;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
class StudentsImport implements ToModel, WithHeadingRow
{
    use Importable, SkipsFailures;
    public function rules(): array{
        return [
            'studentid'  => ['required', 'unique|student:studentid'] || function($sttribute, $value, $onFailure){
                if($value != 'studentid' && !$value){
                    $onFailure('学号'.$value.'重复导入，请重新导入');
                }
            },
            'name'       => 'required',
            'gender'     => 'required'|| function($attribute, $value, $onFailure){
                if($value != 'studentid'){
                    if($value || !preg_match("^(M|F){1}$",strtoupper($value))){
                        $onFailure('性别填写错误');
                    }
                }
            },
            'password'        => 'required',

        ];
    }

    public function model(array $row){
        //跳过标题
        if($row["studentid"] == 'studentid') return null;
        // session_start();
        //查找数据库中学号是否重复
        if(!Student::find($row["studentid"])){
            if(strtoupper($row["gender"])=="M" || strtoupper($row["gender"])=="F"){
                $year = getdate(time())['year'];    //獲取當前年份
                $month = getdate(time())['mon'];    //獲取當前月份
                if($month>8) $current = $year+1;    //計算當前學年
                else $current = $year;
                //创建新生
                return new Student([
                    'studentid'     => $row["studentid"],
                    'dormitoryid'   => null,
                    'name'          => $row["name"],
                    'gender'        => strtoupper($row["gender"]),
                    'classes'       => $current,
                    'pwd'           => Hash::make($row["password"]),
                    'status'        => '住宿',
                ]);
            }else{
                $failmsg = "学号".$row['studentid']." 性别填写错误; ".session()->get('failmsg');
                session()->put("failmsg", $failmsg);
                return;
            }
        }else{
            $failmsg = session()->get('failmsg').$row['studentid']." ";
            session()->put("failmsg", $failmsg);
            return;
        }
    }
    public function headingRow(): int
    {
        return 1;
    }
}
