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

/*Route::get('/', function () {
    return view('welcome');
});*/
//home
Route::get('/', function () {
    return view('staticPages.home');
})->name('home');

//Register User
Route::get('/users/zcp', 'Auth\RegisterController@zhucepage')->name('zcpage');
Route::post('/user/zc', 'Auth\RegisterController@register')->name('register');

//login user
Route::get('/users/dlp', 'Auth\LoginController@showLoginForm')->name('loginPage');
Route::post('/users/dl', 'Auth\LoginController@login')->name('login');

//logout User
Route::post('/users/tc', 'Auth\LoginController@logout')->name('logout');

//nav route
Route::get('/{item}', function ($item) {
    $itemChinese = array(
        'client' => '顾客',
        'medicine' => '药物',
        'agency' => '经办人',
        'orderForm' => '订单'
    );
    return view('layouts._sideNav', compact('item', 'itemChinese'));
});
//browse route
Route::get('/browse/{object}/c', 'BrowseController@show')->name('client.browsePage');
Route::get('/browse/{object}/a', 'BrowseController@show')->name('agency.browsePage');
Route::get('/browse/{object}/m', 'BrowseController@show')->name('medicine.browsePage');

//medicine routes
Route::get('/entry/medicine/page', 'MedicineController@entryMedicinePage')->name('medicine.entryPage');
Route::post('/entry/medicine', 'MedicineController@entryMedicine')->name('medicine.entry');
Route::get('/retrieve/medicine/page', 'MedicineController@retrieveMedicinePage')->name('medicine.retrievePage');
Route::post('/retrieve/medicine', 'MedicineController@retrieveMedicine')->name('medicine.retrieve');
Route::get('/modify/medicine/page', 'MedicineController@modifyMedicinePage')->name('medicine.modifyPage');
Route::get('/modify/medicine/page/{mno}','MedicineController@medicinePage');
Route::post('/modify/medicine', 'MedicineController@modifyMedicine')->name("medicine.modify");
Route::delete('/delete/medicine/{mno}', 'MedicineController@deleteMedicine')->name("medicine.delete");
Route::get('/total/medicine','OrderFormController@total')->name('medicine.total');
//client routes
Route::get('/entry/client/page', function () {
    return view('clients.zhucePage');
})->name('client.entryPage');
Route::post('/entry/client', 'ClientController@entryClient')->name('client.entry');
Route::get('/retrieve/client/page', 'ClientController@retrieveClientPage')->name('client.retrievePage');
Route::post('/retrieve/client', 'ClientController@retrieveClient')->name("client.retrieve");
Route::get('/modify/client/page', 'ClientController@modifyClientPage')->name('client.modifyPage');
Route::get('/modify/client/page/{cno}','ClientController@clientPage');
Route::post('/modify/client', 'ClientController@modifyClient')->name("client.modify");
Route::delete('/delete/client/{cno}','ClientController@deleteClient')->name('client.delete');

//agency routes
Route::get('/entry/agency/page', function () {
    return view('agencies.zhucePage');
})->name('agency.entryPage');
Route::post('/entry/agency', 'AgencyController@entryAgency')->name('agency.entry');
Route::get('/retrieve/agency/page', 'AgencyController@retrieveAgencyPage')->name('agency.retrievePage');
Route::post('/retrieve/agency', 'AgencyController@retrieveAgency')->name("agency.retrieve");
Route::get('/modify/agency/page', 'AgencyController@modifyAgencyPage')->name('agency.modifyPage');
Route::get('/modify/agency/page/{ano}','AgencyController@agencyPage');
Route::post('/modify/agency', 'AgencyController@modifyAgency')->name("agency.modify");
Route::delete('/delete/agency/{id}','AgencyController@deleteAgency')->name('agency.delete');

//orderForm
Route::get('/entry/orderForm/page', 'OrderFormController@entryOrderFormPage')->name('orderForm.entryPage');
Route::post('/entry/orderForm', 'OrderFormController@entryOrderForm')->name("orderForm.entry");

//ajaxTest
Route::get('ajax', function () {
    return view('message');
});
Route::post('/getmsg', 'MedicineController@index');
