<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'CompetitionController@index')->name('home');
Route::get('/create', 'CompetitionController@create')->name('create');
Route::get('/play', 'CompetitionController@play')->name('play');
