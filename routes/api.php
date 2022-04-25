<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// improvment error handling
// refactor / dependancy
// unit test

Route::get('/price', function() {
    $items = \request()->get('parts');

    $fractoryService = new \App\Fractory\Service($items);
    $fractoryService->fillUpPallets();
    $palletsCount = count($fractoryService->getPallets());


    $result = \Illuminate\Support\Facades\Http::retry()->post('http://192.168.1.65:3001/getprice/pallet/', [
        'countryCode' => 'GB',
        'postalCode' => 'PE20 3PW',
        'pallets' => $palletsCount,
    ])->object();

    return json_encode([
        'cost' => $result->totalCost->value,
        'provider' => $result->provider,
        'pallets' => $palletsCount,
    ]);
});
