<?php

use Illuminate\Support\Facades\Route;


// improvement error handling
// refactor / dependency
// unit test

// manipulate with data
\request()->replace(['parts' => [
    [100, 20],
    [900, 50],
    [1900, 50],
]]);

Route::get('/price', \App\Http\Controllers\PriceController::class);
