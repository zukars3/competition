<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'CompetitionController@index')->name('home');
Route::get('/create', 'CompetitionController@create')->name('create');
