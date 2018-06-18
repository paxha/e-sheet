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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function () {
    return \App\User::with('projects.sheets.calculations')->get();
});

Route::resource('projects', 'ProjectController');
Route::resource('sheets', 'SheetController');
Route::get('project-sheets/{project}', 'SheetController@showByProject');
Route::resource('calculations', 'CalculationController');
Route::get('sheet-calculations/{sheet}', 'CalculationController@showBySheet');