<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
*/





Route::resource('stockTransfers', 'StockTransferAPIController');

Route::resource('stockReserves', 'StockReserveAPIController');

Route::resource('orders', 'OrderAPIController');