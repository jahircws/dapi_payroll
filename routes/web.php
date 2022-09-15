<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;

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
Route::middleware('guest')->group(function() {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
});
// Route::get('/generate_employee_id', [IndexController::class, 'generate_employee_id']);
Route::middleware('auth')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [IndexController::class, 'dashboard'])->name('dashboard');

    Route::prefix('employee')->name('employee.')->group(function() {
        Route::get('/list', [IndexController::class, 'employee_list'])->name('list');
        Route::get('/add', [IndexController::class, 'employee_add'])->name('add');
        Route::post('save', [IndexController::class, 'employee_store'])->name('save');
        Route::post('/delete', [IndexController::class, 'employee_delete'])->name('delete');

        Route::get('/salary', [IndexController::class, 'salary'])->name('salary');
        Route::get('/set_salary/{id}', [IndexController::class, 'set_salary'])->name('set_salary');
        Route::post('/store_salary', [IndexController::class, 'store_salary'])->name('store_salary');
        
        Route::get('/get_emp_allowance_details', [IndexController::class, 'get_emp_allowance_details'])->name('get_emp_allowance_details');
        Route::post('/store_salary_allowances', [IndexController::class, 'store_salary_allowances'])->name('store_salary_allowances');
        Route::delete('/delete_allowance', [IndexController::class, 'delete_allowance'])->name('delete_allowance');

        Route::get('/get_emp_deduction_details', [IndexController::class, 'get_emp_deduction_details'])->name('get_emp_deduction_details');
        Route::post('/store_salary_deduction', [IndexController::class, 'store_salary_deduction'])->name('store_salary_deduction');
        Route::delete('/delete_deduction', [IndexController::class, 'delete_deduction'])->name('delete_deduction');

        Route::get('/payout', [IndexController::class, 'payout'])->name('payout');
        Route::get('/get_payroll', [IndexController::class, 'get_payroll'])->name('get_payroll');
        Route::post('/generate_payslip', [IndexController::class, 'generate_payslip'])->name('generate_payslip');
        Route::put('/give_payment', [IndexController::class, 'give_payment'])->name('give_payment');
    });
});

// Route::get('/', [DapiController::class, 'index']);
// Route::post('/get-access-token', [DapiController::class, 'get_access_token']);
// Route::get('/dislink-user', [DapiController::class, 'dislink_user'])->name('dislink.user');

// Route::post('/dapi', function(){
//     header("Access-Control-Allow-Origin: *");
//     header("Content-Type: application/json; charset=UTF-8");
//     header("Access-Control-Allow-Methods: POST");
//     header("Access-Control-Max-Age: 3600");
//     header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//     // Initialize DapiClient with your appSecret here
//     $dapiClient = new Dapi\DapiClient('0f78b93a6c5937ee3af83d2ee30b3d5c302e46b6ab1460e0a01f6675777934a3');

//     $headers = getallheaders();
//     $body = json_decode(file_get_contents("php://input"), true);

//     // Make dapiClient automatically handle your SDK requests
//     if (!empty($body)) {
//     echo json_encode($dapiClient->handleSDKRequests($body, $headers)); 
//     } else {
//     http_response_code(400);
//     echo "Bad Request: No data sent or wrong request";
//     }
// });