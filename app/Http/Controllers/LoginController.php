<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
class LoginController extends Controller
{
    /**
     * 显示给定用户的个人资料。
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    public function show(){
        return view("login");
    }
    public function login(Request $request){
        $choice = $request->input("choice");
        $id = $request->input("id");
        $pwd = $request->input("pwd");
        if($choice == "stu"){
            $std = Student::find($id);
            if(!$std == null && Hash::check($pwd, $std->pwd)){
                session(["user"=>$std]);
                return redirect()->route("student");
            }
            else return redirect()->back();
        }
        else if($choice == "man") {
            $man = Manager::find($id);
            if (!$man==null && Hash::check($pwd, $man->pwd)){
                session(["user"=>$man]);
                return redirect()->route("manager");
            }
            else return redirect()->back();
        }
        else if($choice == "admin"){
            if($id == "admin" && $pwd == "99999")return redirect()->route("admin");
            else return redirect()->back();
            }
        else if($choice == "maintain"){
            if($id == "dantian" && $pwd == "00000")return redirect()->route("maintain");
            else return redirect()->back();
        }
        else return redirect()->back();
    }
}
