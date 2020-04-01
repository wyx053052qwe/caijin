<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('login','Login\LoginController@login');
Route::post('dologin','Login\LoginController@dologin');
Route::prefix('/')->middleware('checklogin')->group(function(){
    Route::get(' ','Admin\AdminController@index');
    Route::get('order','Admin\AdminController@order');
    Route::post('order/status','Admin\AdminController@status');
    Route::post('dels','Admin\AdminController@dels');
    Route::get('orderLogs','Admin\AdminController@orderlogs');
    Route::get('export','Admin\AdminController@export');
    Route::post('odels','Admin\AdminController@odels');
    Route::get('addgong','Admin\AdminController@addgong');
    Route::post('doadd','Admin\AdminController@doadd');
    Route::post('/add/upload','Admin\AdminController@upload');
    Route::get('gongindex','Admin\AdminController@gongindex');
    Route::get('edit','Admin\AdminController@edit');
    Route::post('gong/update','Admin\AdminController@update');
    Route::get('invoiceExport','Admin\AdminController@invoiceExport');
    Route::post('delete','Admin\AdminController@delete');
    Route::post('/add/uploads','Admin\AdminController@uploads');
    Route::post('/add/uploadss','Admin\AdminController@uploadss');
    Route::post('/add/uploadsss','Admin\AdminController@uploadsss');
    Route::get('zh','Admin\AdminController@zh');
    Route::get('addtj','Admin\AdminController@addtj');
    Route::get('jl','Admin\AdminController@jl');
    Route::post('pstatus','Admin\AdminController@pstatus');
    Route::post('pdel','Admin\AdminController@pdel');
    Route::post('doaddtj','Admin\AdminController@doaddtj');
    Route::get('addzh','Admin\AdminController@addzh');
    Route::get('yue','Admin\AdminController@yue');
    Route::get('addsd','Admin\AdminController@addsd');
    Route::post('doaddsd','Admin\AdminController@doaddsd');
    Route::post('doaddzh','Admin\AdminController@doaddzh');
    Route::get('sdindex','Admin\AdminController@sdindex');
    Route::post('del','Admin\AdminController@del');
    Route::get('adduser','Admin\AdminController@adduser');
    Route::post('douser','Admin\AdminController@douser');
    Route::get('userindex','Admin\AdminController@userindex');
    Route::post('udel','Admin\AdminController@udel');
    Route::get('upass','Admin\AdminController@upass');
    Route::post('yuan','Admin\AdminController@yuan');
    Route::get('invioce','Admin\AdminController@invioce');
    Route::post('invoiceimg','Admin\AdminController@invoiceimg');
    Route::post('clickEdit','Admin\AdminController@clickEdit');
    Route::post('invioce/istatus','Admin\AdminController@istatus');
    Route::get('geren','Admin\AdminController@geren');
    Route::post('delvideo','Admin\AdminController@delvideo');
    Route::post('pass','Admin\AdminController@pass');
    Route::get('logout','Admin\AdminController@logout');
});
Route::prefix('/home')->middleware('checklogin')->group(function(){
    Route::get('index','Index\IndexController@home');
    Route::get('contact','Index\IndexController@contact');
    Route::post('docontact','Index\IndexController@docontact');
    Route::get('orderManager','Index\IndexController@orderManager');
    Route::get('uploadSalary','Index\IndexController@uploadSalary');
    Route::post('getSupplierCompanys','Index\IndexController@getSupplierCompanys');
    Route::post('getCustomerFinance','Index\IndexController@getCustomerFinance');
    Route::post('importData','Index\IndexController@importData');
    Route::get('confirmSalary','Index\IndexController@confirmSalary');
    Route::get('confirmSalarys','Index\IndexController@confirmSalarys');
    Route::post('checkMoney','Index\IndexController@checkMoney');
    Route::get('confirmOrder','Index\IndexController@confirmOrder');
    Route::get('tax','Index\IndexController@tax');
    Route::get('download','Index\IndexController@download');
    Route::post('qux','Index\IndexController@qux');
    Route::get('orderLogs','Index\IndexController@orderLogs');
    Route::get('rechargeDesc','Index\IndexController@rechargeDesc');
    Route::get('finance','Index\IndexController@finance');
    Route::get('financeLog','Index\IndexController@financeLog');
    Route::get('rechargeLog','Index\IndexController@rechargeLog');
    Route::get('addRecharge','Index\IndexController@addRecharge');
    Route::post('upload','Index\IndexController@upload');
    Route::post('doadd','Index\IndexController@doadd');
    Route::get('customerAccount','Index\IndexController@customerAccount');
    Route::post('update','Index\IndexController@update');
    Route::get('customerCompany','Index\IndexController@customerCompany');
    Route::get('customerCompanyInfo','Index\IndexController@customerCompanyInfo');
    Route::get('invoiceRaised','Index\IndexController@invoiceRaised');
    Route::post('doraised','Index\IndexController@doraised');
    Route::post('edit','Index\IndexController@edit');
    Route::post('doetid','Index\IndexController@doetid');
    Route::post('del','Index\IndexController@del');
    Route::get('invoiceAddressee','Index\IndexController@invoiceAddressee');
    Route::post('doex','Index\IndexController@doex');
    Route::post('doedit','Index\IndexController@doedit');
    Route::post('updateEx','Index\IndexController@updateEx');
    Route::post('removeExpress','Index\IndexController@removeExpress');
    Route::get('invoiceSm','Index\IndexController@invoiceSm');
    Route::get('invoiceApply','Index\IndexController@invoiceApply');
    Route::post('invoiceTitle','Index\IndexController@invoiceTitle');
    Route::post('expressId','Index\IndexController@expressId');
    Route::post('companyId','Index\IndexController@companyId');
    Route::post('file','Index\IndexController@file');
    Route::post('doinvoiceApply','Index\IndexController@doinvoiceApply');
    Route::post('imgs','Index\IndexController@imgs');
    Route::get('invoiceRecord','Index\IndexController@invoiceRecord');
    Route::get('geren','Index\IndexController@geren');
    Route::post('video','Index\IndexController@video');
    Route::post('dovideo','Index\IndexController@dovideo');
});
