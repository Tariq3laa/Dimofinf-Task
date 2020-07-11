<?php

Route::get('/', function () {
    return redirect(app()->getLocale());
});

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => 'setLocale',
], function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('company', 'CompanyController')->except(['show']);
    Route::get('company/trashed', 'CompanyController@trashed')->name('company.trashed');
    Route::get('company/restore/{id}', 'CompanyController@restore')->name('company.restore');
    Route::get('company/delete/{id}', 'CompanyController@forceDelete')->name('company.delete');

    Route::resource('employee', 'EmployeeController')->except(['show']);
    Route::get('employee/trashed', 'EmployeeController@trashed')->name('employee.trashed');
    Route::get('employee/restore/{id}', 'EmployeeController@restore')->name('employee.restore');
    Route::get('employee/delete/{id}', 'EmployeeController@forceDelete')->name('employee.delete');
});
