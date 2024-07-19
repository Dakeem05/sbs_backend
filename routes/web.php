<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/images/{image}', function ($image) {
    $base = public_path() . '/uploads/images/';

    if (File::exists($base . '/businessImages/' . $image)) {
        return response()->file($base. '/businessImages/' . $image);
    } 
    else if (File::exists($base . '/menuImages/' . $image)) {
        return response()->file($base. '/menuImages/' . $image);
    } 
    else {
        return response('Not found', 404);
    }
});
require __DIR__.'/auth.php';
