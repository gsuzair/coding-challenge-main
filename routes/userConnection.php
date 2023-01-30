<?php


/*
|--------------------------------------------------------------------------
| User Connection Routes
|--------------------------------------------------------------------------
|
*/

use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\SuggestionsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'suggestions'], function () {
    Route::get('/', [SuggestionsController::class, 'index']);
    Route::POST('load_more', [SuggestionsController::class, 'loadMoreSuggestions']);
    Route::POST('connect', [SuggestionsController::class, 'connectSuggestions']);
});

Route::group(['prefix' => 'requests'], function () {
    Route::get('/sent', [RequestController::class, 'index']);
    Route::POST('/sent/load_more', [RequestController::class, 'loadMoreSentRequests']);
    Route::POST('/sent/cancel', [RequestController::class, 'cancelSentRequests']);

    Route::get('/recieved', [RequestController::class, 'index']);
    Route::POST('/recieved/load_more', [RequestController::class, 'loadMoreRecievedRequests']);
    Route::POST('/recieved/accept', [RequestController::class, 'acceptRecievedRequests']);
});

Route::group(['prefix' => 'connections'], function () {
    Route::get('/', [ConnectionController::class, 'index']);
    Route::POST('load_more', [ConnectionController::class, 'loadMoreConnections']);
    Route::POST('remove', [ConnectionController::class, 'removeConnections']);
    Route::POST('common/load_more', [ConnectionController::class, 'loadMoreCommonConnections']);
});