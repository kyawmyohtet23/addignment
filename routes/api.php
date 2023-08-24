<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register'])->name('userRegister');
Route::post('/login', [AuthController::class, 'login'])->name('userLogin');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // index
    Route::get('/index', [EmployeeController::class, 'index'])->name('index');

    // create
    Route::post('/create', [EmployeeController::class, 'store'])->name('createEmployee');
    // delete
    Route::post('/employee/delete/{slug}', [EmployeeController::class, 'destroy'])->name('deleteEmployee');

    // edit
    Route::post('/employee/update/{slug}', [EmployeeController::class, 'update'])->name('updateEmployee');
});
