<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProvinceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestsController;
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
    return view('users.tableusers');
});

Route::get('/insertusers', function () {
    return view('users.insertusers');
})->name('insertusers');




Route::get('/listusers', [UserController::class, 'listUsers'])->name('users.list');

Route::get('/permissionsusers', function (){
    return view('users.permissionsusers');
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

Route::get('/download/{id}', [AdminController::class, 'downloadFile'])->name('admin.download');



Route::post('/createnews',[AdminController::class , 'createnews'])->name('createnews');

Route::post('/changenews/{id}', [AdminController::class, 'changenews']);


Route::get('/deletenews/{id}',[AdminController::class , 'deletenews'])->name('deletenews');

Route::get('/editnews/{id}',[AdminController::class , 'editnews'])->name('editnews');

Route::post('/updatenews/{id}',[AdminController::class , 'updatenews'])->name('updatenews');

Route::get('/search', [AdminController::class, 'search'])->name('search');








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


Route::post('/news/status/{id}', [AdminController::class, 'changenews']);

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

Route::get('/viewInstallFTTx',[ReportController::class , 'datainstallfttx'])->name('viewInstallFTTx');

Route::get('/viewInstallFTTx/{year}',[ReportController::class , 'datainstallfttxYear'])->name('viewInstallFTTxYear');

Route::get('/viewInstallFTTxcenter', [ReportController::class ,'datacenter']);

Route::get('/viewInstallFTTxprovin',[ReportController::class ,'dataprovin'])->name('viewInstallFTTxprovin');

Route::get('/viewInstallFTTxprovin/{section}/{year},{month}',[ReportController::class ,'sortprovin'])->name('viewInstallFTTxprovin');

Route::get('/viewInstallFTTxprovinMonth/{section}/{year}', [ReportController::class ,'sortprovinmonth'])->name('viewInstallFTTxprovinSort');

Route::get('/viewInstallFTTxcenter/{section}/{year}/{month}', [ReportController::class ,'sortcenter'])->name('viewInstallFTTxcenter');

Route::get('/viewInstallFTTxcenter/{center}/{year}/{month}', [ReportController::class, 'viewInstallData']);

Route::get('/ExportInstallFttxcenter', [ReportController::class, 'exportData'])->name('exportInstallFTTxcenter');;
Route::delete('/delete/{year},{month}', [ReportController::class, 'delete_data'])->name('delete_data');

Route::get('/importdata', function () {
    return view('report.importdata');
})->name('importdata');



Route::post('/importdata', [ReportController::class ,'import']);
Route::post('/importdata2', [ReportController::class ,'importFile'])->name('importdata2');

Route::get('/api/existing-months', [ReportController::class, 'getExistingMonths'])->name('api.existing.months');

Route::get('/export/view', [ReportController::class, 'exportview'])->name('export'); // แสดงหน้าเว็บ

Route::get('/data/export', [ReportController::class, 'export']); // Export Excel

Route::get('/api/existing-months2', [ReportController::class, 'getExistingMonths2'])->name('api.existing.months2');

Route::get('/export/view2', [ReportController::class, 'exportview2'])->name('export2'); // แสดงหน้าเว็บ

Route::get('/data/export2', [ReportController::class, 'export2']); // Export Excel



Route::get('/incomecurrent', function () {
    return view('report.incomecurrent');
});
Route::get('/users', [UserController::class, 'listUsers'])->name('users.list');

Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::get('/users/{id}/edit',[UserController::class,'edit'])->name('users.edit');
Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
// Example route protection
Route::middleware(['auth', 'check.permission:manage_users'])->group(function () {
    Route::get('/listusers', [UserController::class, 'listUsers'])->name('users.list');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    // Other user management routes
});

Route::middleware(['auth', 'check.permission:manage_dashboard'])->group(function () {
    Route::get('/listreport', function () {
        return view('report.listreport');
    });
    Route::get('/viewreport', function () {
        return view('report.viewreport');
    });
    // Other report-related routes
});

Route::middleware(['auth', 'check.permission:manage_newsfeed'])->group(function () {
    
    Route::get('/listnewsfeed', [AdminController::class, 'listnewsfeed'])->name('listnewsfeed');
    // Other news-related routes
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/viewreport3', function () {
    return view('report.viewreport3');
});

Route::get('/viewreport3',[ReportController::class , 'viewreport3'])->name('viewreport3');

Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

Route::post('/profile/update-image', [UserController::class, 'updateProfileImage'])
    ->name('profile.update-image')
    ->middleware('auth');

Route::get('/profile', [UserController::class, 'showProfile'])
 ->name('profile')
->middleware('auth'); // Pastikan hanya pengguna yang login yang dapat mengaksesRoute::prefix('categories')->group(function () {
Route::get('/listcategories', [CategoryController::class, 'listcategories'])->name('categories.listcategories');
Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/update/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::get('/delete/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');
Route::get('/search', [CategoryController::class, 'search'])->name('categories.search');
Route::delete('/delete/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');



    Route::get('/requests', [RequestsController::class, 'index'])->name('requests.list');
    Route::get('/requests/create', [RequestsController::class, 'create'])->name('insertRequests');
    Route::post('/requests', [RequestsController::class, 'store'])->name('requests.store');
    Route::get('/requests/{id}/edit', [RequestsController::class, 'edit'])->name('requests.edit');
    Route::put('/requests/{id}', [RequestsController::class, 'update'])->name('requests.update');
    Route::delete('/requests/{id}', [RequestsController::class, 'destroy'])->name('requests.delete');
    Route::get('/requests/search', [RequestsController::class, 'search'])->name('requests.search');
    Route::post('/requests/{id}/approve', [RequestsController::class, 'approve'])->name('requests.approve');
    
Route::get('/news/search', [AdminController::class, 'search'])->name('news.search');
Route::delete('/deletenews/{id}', [AdminController::class, 'deletenews'])->name('deletenews');




//จังหวัด
Route::get('/provinceactivityList',[ProvinceController::class , 'indexprovince'])->name('provinceactivityList');
Route::get('/provinceactivitylnsert',[ProvinceController::class , 'createprovince'])->name('provinceactivitylnsert');
Route::post('/provincactivityadd',[ProvinceController::class , 'storeprovince'])->name('provinceactivityadd');
Route::delete('/provincactivitydelete/{id}',[ProvinceController::class , 'destroyprovince'])->name('provinceactivitydelete');
Route::get('/provincactivityedit/{id}',[ProvinceController::class , 'editprovince'])->name('provinceactivityedit');
Route::put('/provincactivityputedit/{id}',[ProvinceController::class , 'updateprovince'])->name('provinceactivityupdate');


//ศูนย์บริการ
Route::get('/servicecenteractivityList',[ProvinceController::class , 'indexservicecenter'])->name('servicecenteractivityList');
Route::get('/servicecenteractivitylnsert',[ProvinceController::class , 'createservicecenter'])->name('servicecenteractivitylnsert');
Route::post('/servicecenteractivityadd',[ProvinceController::class , 'storeservicecenter'])->name('servicecenteractivityadd');
Route::delete('/servicecenteractivitydelete/{id}',[ProvinceController::class , 'destroyservicecenter'])->name('servicecenteractivitydelete');
Route::get('/servicecenteractivityedit/{id}',[ProvinceController::class , 'editservicecenter'])->name('servicecenteractivityedit');
Route::put('/servicecenteractivityputedit/{id}',[ProvinceController::class , 'updateservicecenter'])->name('servicecenteractivityupdate');

Route::get('/province/{id}/service-centers', [ProvinceController::class, 'viewServiceCenters'])->name('province.viewServiceCenters');
Route::get('/province/{id}/service-center/create', [ProvinceController::class, 'createServiceCenterForProvince'])
    ->name('province.createServiceCenter');
Route::post('/province/{id}/service-center', [ProvinceController::class, 'storeServiceCenterForProvince'])
    ->name('province.storeServiceCenter');