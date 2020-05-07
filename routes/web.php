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

Route::get('/clear-cache', function() {
    // Artisan::call('config:cache');
    Artisan::call('cache:clear');
});

Route::get('/payment/{token}/mode/{mode}/{process_token?}', ['as' => 'payment', 'uses' => 'PaymentController@index']);
Route::post('paypal', 'PaymentController@payWithpaypal');
Route::get('status', ['as' => 'paymentstatus', 'uses' => 'PaymentController@getPaymentStatus']);

Route::group(['namespace' => 'frontend'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('/test', ['as' => 'test', 'uses' => 'HomeController@test']);
    Route::get('/faq', ['as' => 'faq', 'uses' => 'HomeController@faq']);
    Route::get('/sitemap.xml', 'SitemapController@index');
    Route::post('check_text', ['as' => 'check_text', 'uses' => 'ProcessController@check_text']);
    Route::post('check_file', ['as' => 'check_file', 'uses' => 'ProcessController@check_file']);
    Route::get('/project/{token}', ['as' => 'project', 'uses' => 'ProcessController@project']);
    Route::get('/project/status/{token}', ['as' => 'project.status', 'uses' => 'ProcessController@status']);
    Route::get('/project/do-analysis/{token_project}/{token_process}', ['as' => 'project.doAnalysis', 'uses' => 'ProcessController@doAnalysis']);
    Route::get('/project/opentopresult/{token_project}', ['as' => 'project.opentopresult', 'uses' => 'ProcessController@openTopResult']);
    Route::get('/project/openresult/{token_project}/{token_process}', ['as' => 'project.openresult', 'uses' => 'ProcessController@openResult']);
    Route::get('/project/getresult/{token_project}', ['as' => 'project.getresult', 'uses' => 'ProcessController@getResult']);
    Route::get('/project/{token}/checked-list', ['as' => 'project.checked_list', 'uses' => 'ProcessController@checked_list']);
    Route::get('/email-verify/{email}/token/{token}', ['as' => 'email_verify', 'uses' => 'ProcessController@verify']);
    Route::get('/set-email/email/{email}/token/{token}', ['as' => 'set_email', 'uses' => 'ProcessController@set_email']);
    Route::get('/email-set-verify/{email}/token/{token}', ['as' => 'email_set_verify', 'uses' => 'ProcessController@set_verify']);
    Route::get('/deletefile/{token}', ['as' => 'deletefile', 'uses' => 'ProcessController@destroy']);
    Route::get('/plag_checkprice', ['as' => 'plag_checkprice', 'uses' => 'HomeController@plag_checkprice']);
});


Route::group(['namespace' => 'backend', 'prefix' => 'admin'], function () {
    Auth::routes();
    Route::get('/logout', ['as' => 'admin.logout', 'uses' => 'AdminController@logout']);
    Route::get('/dashboard', ['as' => 'admin.dashboard', 'uses' => 'AdminController@index']);
    Route::get('/setting', ['as' => 'admin.setting', 'uses' => 'AdminController@setting']);
    Route::post('setting', ['as' => 'admin.setsetting', 'uses' => 'AdminController@setSetting']);
    Route::get('/payrecord', ['as' => 'admin.payrecord', 'uses' => 'AdminController@payrecord']);
    Route::get('/payrecord_global', ['as' => 'admin.payrecord_global', 'uses' => 'AdminController@payrecord_global']);
    Route::get('/activity', ['as' => 'admin.activity', 'uses' => 'AdminController@activity']);
    Route::get('/counter_stats', ['as' => 'admin.counter_stats', 'uses' => 'AdminController@counter_stats']);
});

// 404 Route Handler
Route::any('{url_param}', function() {
    abort(404, '404 Error. Page not found!');
})->where('url_param', '.*');



