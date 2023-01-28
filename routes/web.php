<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
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
Route::get('/clear-cache', function () {

    $configCache = Artisan::call('config:cache');
    $clearCache = Artisan::call('cache:clear');

    // return what you want
});

Route::get('/qpay/paid', 'SmsController@qpaypaid');


//Auth::routes(['register' => true]);
Auth::routes();

Route::prefix('account')->group(function () {
    Route::get('/save', 'AccountController@index')->name('account.save');
    Route::post('/save', 'AccountController@save');
    Route::get('/manage', 'AccountController@manage');
    Route::get('/edit/{id}', 'AccountController@edit');
    Route::post('/edit', 'AccountController@update');
    Route::get('/delete/{id}', 'AccountController@delete');

});

Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('user')->group(function () {
    Route::get('/manage', 'UserController@manage');
    Route::get('/edit/{id}', 'UserController@edit');
    Route::post('/edit', 'UserController@update');
    Route::get('/delete/{id}', 'UserController@delete');
    Route::get('/det/{id}', 'UserController@det'); 
    Route::post('/addlot', 'UserController@addlot');

});

Route::prefix('price')->group(function () {
    Route::get('/manage', 'PriceController@manage');
    Route::get('/edit/{id}', 'PriceController@edit');
    Route::post('/edit', 'PriceController@update');
    Route::get('/save', 'PriceController@index')->name('price.save');
    Route::post('/save', 'PriceController@save');

});



Route::prefix('loan')->group(function () {
    Route::get('/save', 'LoanController@index')->name('loan.save');
    Route::post('/save', 'LoanController@save');
    Route::get('/manage', 'LoanController@manage');
    Route::get('/edit/{id}', 'LoanController@edit');
    Route::post('/edit', 'LoanController@update');
    Route::get('/delete/{id}', 'LoanController@delete');

});


Route::prefix('wall')->group(function () {
    Route::get('/save', 'WallController@index')->name('loan.save');
    Route::post('/save', 'WallController@save');
    Route::get('/manage', 'WallController@manage');
    Route::get('/edit/{id}', 'WallController@edit');
    Route::post('/edit', 'WallController@update');
    Route::get('/delete/{id}', 'WallController@delete');

});



Route::prefix('sett')->group(function () {
    Route::get('/save', 'SettController@index')->name('sett.save');
    Route::post('/save', 'SettController@save');
    Route::get('/manage', 'SettController@manage');
    Route::get('/edit/{id}', 'SettController@edit');
    Route::post('/edit', 'SettController@update');
    Route::get('/delete/{id}', 'SettController@delete');

});


Route::prefix('lott')->group(function () {
    Route::get('/save', 'LottController@index')->name('lott.save');
    Route::post('/save', 'LottController@save');
    Route::get('/manage', 'LottController@manage');
    Route::get('/edit/{id}', 'LottController@edit');
    Route::post('/edit', 'LottController@update');
    Route::get('/delete/{id}', 'LottController@delete');

});

Route::prefix('quarter')->group(function () {
    Route::get('/save', 'QuarterController@index')->name('quarter.save');
    Route::post('/save', 'QuarterController@save');
    Route::get('/manage', 'QuarterController@manage');
    Route::get('/edit/{id}', 'QuarterController@edit');
    Route::post('/edit', 'QuarterController@update');
    Route::get('/delete/{id}', 'QuarterController@delete');

});

Route::prefix('slider')->group(function () {
    Route::get('/save', 'SliderController@index')->name('slider.save');
    Route::post('/save', 'SliderController@save');
    Route::get('/manage', 'SliderController@manage');
    Route::get('/edit/{id}', 'SliderController@edit');
    Route::post('/edit', 'SliderController@update');
    Route::get('/delete/{id}', 'SliderController@delete');

});


Route::prefix('loanSms')->group(function () {
    Route::get('/manage', 'LoanSmsController@manage')->name('loansms');
    Route::get('/paidlist', 'LoanSmsController@paidlist')->name('paidlist');
});

Route::prefix('leads')->group(function () {
    Route::get('/manage', 'LeadController@manage')->name('leads');
    Route::get('/save', 'LeadController@index');
    Route::get('/delete/{id}', 'LeadController@delete');
    Route::post('/excel_import_file', [LeadController::class, 'excelImport'])->name('request.excel_import_file');
    Route::post('/save', 'LeadController@save');
    Route::get('/fix/{id}', 'LeadController@fix');
    Route::post('/edit', 'LeadController@update');

    Route::post('/comment', 'LeadController@comment');
    Route::get('/detail/{id}', 'LeadController@detail')->name( 'leads.id');
    Route::get('/datatable-req', [LeadController::class, 'loadRequestDataTable'])->name('datatable-req'); 

});


Route::prefix('allcredit')->group(function () {
    Route::get('/save', 'CreditController@index')->name('allcredit.save');
    Route::post('/save', 'CreditController@save');
    Route::post('/manage', 'CreditController@manage')->name('allcredit.manage');
    Route::post('/delete', 'CreditController@delete');
    Route::get('/credits', 'CreditController@credits')->name('allcredit.credits');
    Route::post('/filter/credits', 'CreditController@filtercredit');

});

Route::prefix('statment')->group(function () {
    Route::post('/save/changed/{number}', 'StatmentController@saveChangedStatments');
    Route::get('/changed/list', 'StatmentController@changed_statments');
    Route::post('/qpay_autopush/{account}', 'StatmentController@qpay_autopush');
    Route::post('/procreditorpush/{id}', 'StatmentController@procreditorpush');
    Route::delete('/record/{id}', 'StatmentController@destroyChangedStatment')->name('statments.destroy');
});


Route::prefix('khan')->group(function () {
    Route::get('/', 'KhanAccountController@index');
    Route::post('/syncaccounts', 'KhanAccountController@syncaccount');

    Route::get('/statments/{number}', 'KhanAccountController@statments');
    Route::get('statmentsync/{number}', 'KhanAccountController@syncstatements');
    Route::post('/edit', 'AccountController@update');
    Route::get('/delete/{id}', 'AccountController@delete');

});



//Route::get('/export/{number}', 'StatmentController@excel')->name('export_excel.excel');
Route::get('/export_excel/excel/{number}', 'StatmentController@exportspread');
Route::get('/export_excel/account/statments', 'StatmentController@exportspread_statments');
Route::get('/export_excel/account/changedstatments', 'StatmentController@export_changed_statments');

Route::get('/export_invoice/excel/{number}', 'ReportController@exportinvoice');
Route::get('/export_paid/invoices', 'ReportController@exportpaidinvoices');
Route::get('/export_excel/sms', 'ReportController@exportsms');
Route::get('/export/credits', 'ReportController@exportcredits');
Route::get('/export/credits2', 'ReportController@exportcredits2');


Route::prefix('mobicom')->group(function () {
    Route::get('/import', 'MobicomController@import');
    Route::post('/import', 'MobicomController@import');
    Route::post('/sendsms', 'MobicomController@sendsms');
});


