<?php

use App\Http\Controllers\Index;
use App\Http\Controllers\User\SignIn;
use App\Http\Controllers\Work\Work;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Work\Entry;
use App\Http\Controllers\System\OperationFinished;
use App\Http\Controllers\Work\Audit;
use App\Http\Controllers\Work\DataRegulate;
use App\Http\Controllers\Work\ProjectSetting;

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

Route::any('/', [Index::class, "index"]);

// 错误/成功 处理
Route::any('/system/work_error', [OperationFinished::class, 'WorkError']);
Route::any('/system/work_success', [OperationFinished::class, 'WorkSuccess']);

// 用户相关路由
Route::any('/user/sign_in', [SignIn::class, "SignIn"]);
Route::post('/user/sign_in/check', [SignIn::class, "SignInCheck"]);

// 工作系统相关路由
Route::any('/work', [Work::class, 'Work'])->middleware('user_control');
Route::any('/work/data_entry', [Entry::class, 'Entry'])->middleware('user_control');
Route::any('/work/data_entry/input', [Entry::class, 'EntryInput'])->middleware('user_control');
Route::any('/work/data_entry/input/check', [Entry::class, 'EntryInputCheck'])->middleware('user_control');
Route::any('/work/data_audit', [Audit::class, 'Audit'])->middleware('user_control');
Route::any('/work/data_audit/check', [Audit::class, 'AuditCheck'])->middleware('user_control');
Route::any('/work/data_view', [DataRegulate::class, 'DataView'])->middleware('user_control');
Route::any('/work/data_view/check', [DataRegulate::class, 'DataViewCheck'])->middleware('user_control');
Route::any('/work/data_regulate', [DataRegulate::class, 'DataRegulate'])->middleware('user_control');
Route::any('/work/data_regulate/check', [DataRegulate::class, 'DataRegulateCheck'])->middleware('user_control');
Route::any('/work/data_regulate/regulate/check', [DataRegulate::class, 'DataRegulateEditCheck'])->middleware('user_control');
Route::any('/work/project_setting', [ProjectSetting::class, 'ProjectSetting'])->middleware('user_control');
Route::any('/work/project_setting/edit', [ProjectSetting::class, 'ProjectEdit'])->middleware('user_control');
Route::any('/work/project_setting/edit/check', [ProjectSetting::class, 'ProjectCheck'])->middleware('user_control');


Route::any('test', [\App\Http\Controllers\Test::class, 'Test']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
