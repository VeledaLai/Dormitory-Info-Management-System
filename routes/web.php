<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MaintainController;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentExport;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function(){
    return view("login");
})->name("login");
Route::post('/', [LoginController::class,'login']);
Route::get('/logout', function(Request $request){
    $request->session()->flush();
    return redirect('/');
})->name("login");
Route::group(['prefix'=>'student'] , function() {
    //學生主頁
    Route::get('/' , [StudentController::class, 'index'])->name("student");
    //報修
    Route::get('/repair' , [StudentController::class, 'repair'])->name("repair");
    Route::post('/repair' , [StudentController::class, 'repair_submit']);
    //缴纳住宿费
    Route::get('/payment', [StudentController::class, 'payment'])->name("payment");
    Route::post('/payment', [StudentController::class, 'pay']);
    //離校返校登記
    Route::get('/leave_return', [StudentController::class, 'leave_return'])->name("leave_return");
    Route::post('/leave_return',[StudentController::class,'leave_return_record']);
    //夜歸信息
    Route::get('/late', [StudentController::class, 'late'])->name("late");
    //水电费
    Route::get('/fee', [StudentController::class, 'fee'])->name("fee");
    Route::post('/fee', [StudentController::class, 'fee_submit']);
    //寢室信息
    Route::get('/dormitory', [StudentController::class, 'dormitory'])->name("dormitory");
    //入退宿申请
    Route::get('/check_in_out', [StudentController::class, 'check_in_out'])->name("check_in_out");
    Route::post('/check_in_out', [StudentController::class, 'check_in_out_apply']);
});

Route::group(['prefix'=>'admin'] , function() {
    //社區主頁
    Route::get('/' , [AdminController::class, 'index'])->name("admin");
    //新生入住
    Route::get('/freshman', [AdminController::class, 'freshman'])->name("freshman");
    Route::post('/export', [AdminController::class, 'freshmanexport'])->name("freshmanexport");
    Route::post('/import', [AdminController::class, 'import'])->name('import');
    //入住申請
    Route::get('/checkin' , [AdminController::class, 'checkin'])->name("checkin");
    Route::post('/checkin' , [AdminController::class, 'checkin_submit']);
    //退宿申請
    Route::get('/checkout' , [AdminController::class, 'checkout'])->name("checkout");
    Route::post('/checkout' , [AdminController::class, 'checkout_submit']);
    //寢室調動
    Route::get('/change' , [AdminController::class, 'change'])->name("change");
    Route::post('/change' , [AdminController::class, 'change_find']);
    Route::post('/change_submit' , [AdminController::class, 'change_submit']);
    //繳費信息
    Route::get('/payment' , [AdminController::class, 'payment'])->name("payment");
    Route::post('/payment' , [AdminController::class, 'payment_renew']);
    Route::post('/payment_download/{status}', function ($status) {
        $year = getdate(time())['year'];    //獲取當前年份
        $month = getdate(time())['mon'];    //獲取當前月份
        if($month>8) $current = $year+1;    //計算當前學年
        else $current = $year;
        return Excel::download(new PaymentExport($status), $current.' 学年缴费情况.xlsx');
    })->name('export');
    //樓棟管理
    Route::get('/building' , [AdminController::class, 'building'])->name("building");
    Route::post('/building' , [AdminController::class, 'add_building']);
});

Route::group(['prefix'=>'manager'] , function() {
    //宿管主頁
    Route::get('/' , [ManagerController::class, 'index'])->name("manager");
    //宿舍信息管理
    Route::get('/info',[ManagerController::class, 'info'])->name("info");
    Route::post('/checkinfo_submit',[ManagerController::class, 'info_submit']);
    //宿舍水电管理
    Route::get('/fee_manager',[ManagerController::class, 'fee'])->name("fee_manager");
    Route::post('/fee_manager',[ManagerController::class, 'fee_submit'])->name("fee_submit");
    //宿舍报修管理
    Route::get('/maintain',[ManagerController::class, 'maintain'])->name("maintain_manager");
    Route::post('/maintain',[ManagerController::class, 'maintain_submit']);
    //宿舍夜归管理
    Route::get('/late',[ManagerController::class, 'late'])->name("late_manager");
    Route::post('/late',[ManagerController::class, 'late_find'])->name("late_manager");
    Route::post('/late_submit',[ManagerController::class, 'late_submit']);
});

Route::group(['prefix'=>'maintain'] , function() {
    //物業主頁
    Route::get('/' , [MaintainController::class, 'index'])->name("maintain");
    //報修項目管理
    Route::get('/repair' , [MaintainController::class, 'repair'])->name("repair");
    Route::post('/repair' , [MaintainController::class, 'repair']);
    Route::post('/repair_submit' , [MaintainController::class, 'repair_submit']);
    //水電費管理
    Route::get('/fee' , [MaintainController::class, 'fee'])->name("fee");
    Route::post('/fee' , [MaintainController::class, 'fee']);
    Route::post('/fee_submit' , [MaintainController::class, 'fee_submit']);
});
