<?php

use Illuminate\Support\Facades\Route;


Route::get('/welcome', function () {
    return view('welcome');
});
//langsung masuk ke login
Route::redirect('/', '/admin');
