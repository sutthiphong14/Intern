<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProvinceController;
use App\Models\UserLog;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestsController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SlideshowController;
use App\Models\Fttxbroadband;

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

Route::get('/user-logs', function () {
    // Eager load the user relationship to avoid N+1 query problem
    $logs = UserLog::with('user')->orderBy('created_at', 'desc')->get();
    return view('user-logs.listlogs', compact('logs'));
})->name('user-logs');


Route::get('/admins', function () {
    return view('admins.index');
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/structure', function () {
    return view('structure');
})->name('structure');


Route::get('/tableusers', function () {
    return view('users.tableusers');
});

Route::get('/insertusers', function () {
    return view('users.insertusers');
})->name('insertusers');




Route::get('/listusers', [UserController::class, 'listUsers'])->name('users.list');

Route::get('/permissionsusers', function () {
    return view('users.permissionsusers');
});

Route::get('/updatenewsfeed', function () {
    return view('newsfeed.updatenewsfeed');
});



Route::get('/listnewsfeed', [AdminController::class, 'listnewsfeed'])->name('listnewsfeed');

Route::get('/insertnewsfeed', function () {
    return view('newsfeed.insertnewsfeed');
})->name('insertnewsfeed');

Route::get('/newsfeed', function () {
    return view('newsfeed.newsfeed');
});

Route::get('/newsfeed',[AdminController::class , 'newsfeed'])->name('newsfeed');

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/download/{id}', [AdminController::class, 'downloadFile'])->name('admin.download');



Route::post('/createnews', [AdminController::class, 'createnews'])->name('createnews');

Route::post('/changenews/{id}', [AdminController::class, 'changenews']);


Route::get('/deletenews/{id}', [AdminController::class, 'deletenews'])->name('deletenews');

Route::get('/editnews/{id}', [AdminController::class, 'editnews'])->name('editnews');

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

Route::get('/viewInstallFTTx', [ReportController::class, 'datainstallfttx'])->name('viewInstallFTTx');

Route::get('/viewInstallFTTx/{year}', [ReportController::class, 'datainstallfttxYear'])->name('viewInstallFTTxYear');

Route::get('/viewInstallFTTxcenter', [ReportController::class, 'datacenter']);

Route::get('/viewInstallFTTxprovin', [ReportController::class, 'dataprovin'])->name('viewInstallFTTxprovin');

Route::get('/viewInstallFTTxprovin/{section}/{year},{month}', [ReportController::class, 'sortprovin'])->name('viewInstallFTTxprovin');

Route::get('/viewInstallFTTxprovinMonth/{section}/{year}', [ReportController::class, 'sortprovinmonth'])->name('viewInstallFTTxprovinSort');

Route::get('/viewInstallFTTxcenter/{section}/{year}/{month}', [ReportController::class, 'sortcenter'])->name('viewInstallFTTxcenter');

Route::get('/viewInstallFTTxcenter/{center}/{year}/{month}', [ReportController::class, 'viewInstallData']);

Route::get('/ExportInstallFttxcenter', [ReportController::class, 'exportData'])->name('exportInstallFTTxcenter');;
Route::delete('/delete/{year},{month}', [ReportController::class, 'delete_data'])->name('delete_data');

Route::get('/importdata', function () {
    return view('report.importdata');
})->name('importdata');



Route::post('/importdata', [ReportController::class, 'import']);
Route::post('/importdata2', [ReportController::class, 'importFile'])->name('importdata2');

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

Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
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

Route::get('/viewreport3', [ReportController::class, 'viewreport3'])->name('viewreport3');

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

Route::get('/edit_banner', function () {
    return view('manage_images.edit_banner');
})->name('edit_banner');

Route::get('/edit_banner', [SlideshowController::class, 'showBanners'])->name('edit_banner');
Route::post('/slideshow', [SlideshowController::class, 'store'])->name('slideshows.store');
Route::put('/slideshow/{id}', [SlideshowController::class, 'update'])->name('slideshow.update');

Route::get('/slideshow/{id}/edit', [SlideshowController::class, 'edit'])->name('slideshow.edit');
Route::delete('/slideshow/{id}', [SlideshowController::class, 'destroy'])->name('slideshow.destroy');
Route::delete('/edit_banner/{id}', [SlideshowController::class, 'destroy'])->name('edit_banner.destroy');
Route::delete('/slideshow/{id}', [SlideshowController::class, 'destroy'])->name('slideshow.destroy');




//ส่วนกิจกรรม
Route::get('/typeactivity_list', [ActivityController::class, 'ListType'])->name('type_list');
Route::post('/typeactivity_insert', [ActivityController::class, 'TypeInsert'])->name('type_insert');
Route::delete('/typeactivity_delete/{type_id}', [ActivityController::class, 'TypeDelete'])->name('type_delete');
Route::put('/typeactivity_update/{type_id}', [ActivityController::class, 'Typeupdate'])->name('type_update');


//ส่วนที่ใช้ส่วนบริการ
Route::get('/severactivity_list/{type_id}', [ActivityController::class, 'ListService'])->name('service_list');
Route::post('/severactivity_insert', [ActivityController::class, 'ServiceInsert'])->name('service_insert');
Route::delete('/severactivity_delete/{service_id}', [ActivityController::class, 'ServiceDelete'])->name('service_delete');
Route::put('/severactivity_update/{service_id}', [ActivityController::class, 'Serviceupdate'])->name('serve_update');

//ส่วนโปรโมชัน
Route::get('/promotion_list/{service_id}', [ActivityController::class, 'ListPromotion'])->name('promotion_list');
Route::post('/promotion_insert/{service_id}', [ActivityController::class, 'PromotionInsert'])->name('promotion_insert');
Route::delete('/promotion_delete/{service_id}/{promotion_id}', [ActivityController::class, 'PromotionDelete'])->name('promotion_delete');
Route::put('/promotion_update/{service_id}/{promotion_id}', [ActivityController::class, 'PromotionUpdate'])->name('promotion_update');

//ส่วนสปีด
Route::get('/speed_list/{service_id}/{promotion_id}', [ActivityController::class, 'ListSpeed'])->name('speed_list');
Route::post('/speed_insert/{service_id}/{promotion_id}', [ActivityController::class, 'SpeedInsert'])->name('speed_insert');
Route::delete('/speed_delete/{service_id}/{promotion_id}/{speed_id}', [ActivityController::class, 'SpeedDelete'])->name('speed_delete');
Route::put('/speed_update/{service_id}/{promotion_id}/{speed_id}', [ActivityController::class, 'SpeedUpdate'])->name('speed_update');

//ราคา
Route::get('/price_list/{service_id}/{promotion_id}/{speed_id}', [ActivityController::class, 'ListPrice'])->name('price_list');
Route::post('/price_insert/{service_id}/{promotion_id}/{speed_id}', [ActivityController::class, 'PriceInsert'])->name('price_insert');
Route::delete('/price_delete/{service_id}/{promotion_id}/{speed_id}/{price_id}', [ActivityController::class, 'PriceDelete'])->name('price_delete');
Route::put('/price_update/{service_id}/{promotion_id}/{speed_id}/{price_id}', [ActivityController::class, 'PriceUpdate'])->name('price_update');

//ส่วนproduct
Route::get('/product_list,{type_id}', [ActivityController::class, 'ListProduct'])->name('product_list');
Route::post('/product_insert,{type_id}', [ActivityController::class, 'ProductInsert'])->name('product_insert');
Route::delete('/product_delete/{product_id}', [ActivityController::class, 'ProductDelete'])->name('product_delete');
Route::put('/product_update/{product_id}', [ActivityController::class, 'Productupdate'])->name('product_update');

//จังหวัด
Route::get('/provinceactivityList', [ProvinceController::class, 'indexprovince'])->name('provinceactivityList');
Route::post('/provincactivityadd', [ProvinceController::class, 'storeprovince'])->name('provinceactivityadd');
Route::delete('/provincactivitydelete/{id}', [ProvinceController::class, 'destroyprovince'])->name('provinceactivitydelete');
Route::put('/provincactivityputedit/{id}', [ProvinceController::class, 'updateprovince'])->name('provinceactivityupdate');

//ศูนย์บริการ
Route::get('/province/{id}/service-centers', [ProvinceController::class, 'viewServiceCenters'])->name('province.viewServiceCenters');
Route::post('/province/{id}/service-center', [ProvinceController::class, 'storeServiceCenterForProvince'])->name('province.storeServiceCenter');
Route::delete('/servicecenteractivitydelete/{id}', [ProvinceController::class, 'destroyservicecenter'])->name('servicecenteractivitydelete');
Route::put('/servicecenteractivityputedit/{id}', [ProvinceController::class, 'updateservicecenter'])->name('servicecenteractivityupdate');

//ลูกค้า
Route::get('/customer_list', [CustomerController::class, 'CustomerList'])->name('customer_list');
Route::get('/customer_create_view/{type_id}', [CustomerController::class, 'CustomerCreate'])->name('customer_create');
Route::post('/customer_insert', [CustomerController::class, 'CustomerInsert'])->name('customer_insert');
Route::delete('/customer_delete/{cus_id}', [CustomerController::class, 'CustomerDelete'])->name('customer_delete');
Route::get('/customer_edit/{cus_id}', [CustomerController::class, 'CustomerEdit'])->name('customer_edit');
Route::put('/customer_update/{cus_id}', [CustomerController::class, 'CustomerUpdate'])->name('customer_update');

Route::get('/fttx_broadband', [ActivityController::class, 'Fttxlist'])->name('fttx_broadband');
Route::get('/sim_my', [ActivityController::class, 'Sim_my'])->name('sim_my');
Route::get('/activity_list', [ActivityController::class, 'activity_list'])->name('activity_list');

Route::get('/getService', [CustomerController::class, 'getService']);
Route::get('/getProduct', [CustomerController::class, 'getProduct']);
Route::get('/getPromotions', [CustomerController::class, 'getPromotions']);
Route::get('/getSpeeds', [CustomerController::class, 'getSpeeds']);
Route::get('/getPrices', [CustomerController::class, 'getPrices']);
Route::get('/getCenters', [CustomerController::class, 'getCenters']);
Route::get('/customers/search', [CustomerController::class, 'searchCustomers'])->name('customer_search');



Route::post('/topUp_insert', [CustomerController::class,'insertTopup'])->name('topUp_insert');
Route::delete('/topUp_delete/{topUp_id}', [CustomerController::class, 'TopUpDelete'])->name('topUp_delete');
Route::put('/topUp_update/{id}', [CustomerController::class, 'TopUpUpdate'])->name('topUp_update');
Route::get('/getTopUpDetails/{topUpId}', [CustomerController::class, 'getTopUpDetails'])->name('getTopUpDetails');


Route::get('/Event_deparment/{type_id}', [ActivityController::class, 'EventDepartment'])->name('event_department');
Route::get('/Event_services/{province_id},{type_id}', [ActivityController::class, 'Eventservices'])->name('event_services');
Route::get('/Event_center/{province_id},{type_id}', [ActivityController::class, 'Eventcenter'])->name('event_center');
Route::get('/Event_customer_list/{type_id}', [ActivityController::class, 'EventCustomer'])->name('event_customer');
Route::get('/topup_list/{type_id}', [ActivityController::class, 'TopUp_list'])->name('top_up_list');
Route::get('/topups/search', [ActivityController::class, 'searchTopUp'])->name('top_up_search');
Route::get('/get_product/{center_id}/{type_id}', [ActivityController::class, 'getProductCenter'])->name('getproduct_center');
Route::get('/detail/{center_id}', [ActivityController::class, 'getCustomerDetail'])->name('detail_cus');













