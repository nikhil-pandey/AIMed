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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/d/{dataset}', 'DatasetController@show');
Route::get('/d/{dataset}/edit', 'DatasetController@edit');
Route::put('/d/{dataset}', 'DatasetController@update');
Route::post('/d/{dataset}/file', 'DatasetFileController@upload');
Route::get('/datasets', 'DatasetController@index');
Route::get('/datasets/publish', 'DatasetController@create');
Route::post('/datasets', 'DatasetController@store');
Route::get('/predict/heart', 'HeartDiseasePredictionController@form');
Route::post('/predict/heart', 'HeartDiseasePredictionController@predict');
Route::get('/predict/diabetes', 'DiabetesPredictionController@form');
Route::post('/predict/diabetes', 'DiabetesPredictionController@predict');