<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ThreeController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EfiankeyController;
use App\Http\Controllers\Question1Controller;
use App\Http\Controllers\Question2Controller;
use App\Http\Controllers\Question3Controller;
use App\Http\Controllers\Question4Controller;
use App\Http\Middleware\CheckDownloadRestriction;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/Newpage', [PageController::class, 'newPage'])->name('Newpage');
Route::get('/testThree', [ThreeController::class, 'testThree']);
Route::get('/login', [LoginController::class, 'login']);
Route::get('/googleLogin', [GoogleController::class, 'redirect'])->name('googleLogin');
Route::get('/googleLogin/callbackgoogle', [GoogleController::class, 'callbackgoogle']);
Route::get('/Question1', [Question1Controller::class, 'viewHomePage'])->name('Question1');
Route::get('/Question2', [Question2Controller::class, 'viewHomePage'])->name('Question2');
Route::post('/submit-form', [Question2Controller::class, 'checkDiscount'])->name('form.submit');
Route::get('/Question3', [Question3Controller::class, 'viewHomePage'])->name('Question3');
Route::post('/Question3/submit-form', [Question3Controller::class, 'checkDate'])->name('q3.form.submit');
Route::get('/Question4', [Question4Controller::class, 'viewHomePage'])->name('Question4');
Route::post('/Question4/submit-form', [Question4Controller::class, 'get_roll_item_result'])->name('q4.form.submit');

