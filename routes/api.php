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


Route::prefix('v1')->group(function () {
    Route::prefix('sort')->group(function () {
        Route::get('/', [\App\Http\Controllers\Sort\SortController::class, 'index']);
        Route::get('/merge', [\App\Http\Controllers\Sort\MergeSortController::class, 'index']);
        Route::get('/quick', [\App\Http\Controllers\Sort\QuickSortController::class, 'index']);
        Route::get('/heap', [\App\Http\Controllers\Sort\HeapSortController::class, 'index']);
        Route::get('/insertion', [\App\Http\Controllers\Sort\InsertionSortController::class, 'index']);
        Route::get('/selection', [\App\Http\Controllers\Sort\SelectionSortController::class, 'index']);
        Route::get('/bubble', [\App\Http\Controllers\Sort\BubbleSortController::class, 'index']);
    });
    Route::prefix('search')->group(function () {
//        Route::get('/', [\App\Http\Controllers\Sort\SortController::class, 'index']);
        Route::get('/binary', [\App\Http\Controllers\Search\BinarySearchController::class, 'index']);
    });
});

