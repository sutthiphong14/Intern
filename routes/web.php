<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/admins', function () {
    return view('admins.index');
});

Route::get('/', function (){
    return view('home');
});

Route::get('/home', function (){
    return view('home');
});

Route::get('/structure', function (){
    return view('structure') ;
})->name('structure');


Route::get('/tableusers', function (){
    return view('tableusers');
});

Route::get('/insertusers', function (){
    return view('insertusers');
});

Route::get('/listusers', function (){
    return view('users.listusers');
});

Route::get('/updatenewsfeed', function (){
    return view('newsfeed.updatenewsfeed');
});

Route::get('/listnewsfeed',[AdminController::class , 'listnewsfeed'])->name('listnewsfeed');

Route::get('/insertnewsfeed', function (){
    return view('newsfeed.insertnewsfeed');
});

Route::get('/newsfeed', function (){
    return view('newsfeed.newsfeed');
});

Route::get('/newsfeed',[AdminController::class , 'newsfeed'])->name('newsfeed');

Route::get('/profile', function (){
    return view('profile');
});


Route::post('/createnews',[AdminController::class , 'createnews'])->name('createnews');

Route::post('/changenews/{id}', [AdminController::class, 'changenews']);


Route::get('/deletenews/{id}',[AdminController::class , 'deletenews'])->name('deletenews');

Route::get('/editnews/{id}',[AdminController::class , 'editnews'])->name('editnews');

Route::post('/updatenews/{id}',[AdminController::class , 'updatenews'])->name('updatenews');

Route::get('/search', [AdminController::class, 'search'])->name('search');







use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index'])->name('users.index');


/* ************************************************************layout************************************************************ */
Route::get('/layouts.invoice', function () {
    return view('layouts.invoice');
});

Route::get('/layouts.ui-general', function () {
    return view('layouts.ui-general');
});


Route::get('/layouts.modals', function () {
    return view('layouts.modals');
});

Route::get('/layouts.editors', function () {
    return view('layouts.editors');
});

Route::get('/layouts.data', function () {
    return view('layouts.data');
});

Route::get('/layouts.sliders', function () {
    return view('layouts.sliders');
});

Route::get('/layouts.profile', function () {
    return view('layouts.profile');
});

Route::get('/layouts.timeline', function () {
    return view('layouts.timeline');
});

Route::get('/layouts.advanced', function () {
    return view('layouts.advanced');
});

Route::get('/layouts.buttons', function () {
    return view('layouts.buttons');
});

Route::get('/layouts.calendar', function () {
    return view('layouts.calendar');
});

Route::get('/layouts.chartjs', function () {
    return view('layouts.chartjs');
});

Route::get('/layouts.form-general', function () {
    return view('layouts.form-general');
});
Route::get('/layouts.ribbons', function () {
    return view('layouts.ribbons');
});
Route::get('/layouts.flot', function () {
    return view('layouts.flot');
});

/* ************************************************************layout************************************************************ */
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




/* ************************************************************report************************************************************ */
Route::get('/listreport', function () {
    return view('report.listreport');
});

Route::get('/viewreport', function () {
    return view('report.viewreport');
});

Route::get('/viewreport1', function () {
    return view('report.viewreport1');
});

Route::get('/viewInstallFTTx', action: function () {
    return view('report.viewInstallFTTx');
});

Route::get('/viewInstallFTTxcenter', function () {
    return view('report.viewInstallFTTxcenter');
});

Route::get('/viewInstallFTTxprovin', function () {
    return view('report.viewInstallFTTxprovin');
});

Route::get('/importdata', function () {
    return view('report.importdata');
});
Route::get('/incomecurrent', function () {
    return view('report.incomecurrent');
});

