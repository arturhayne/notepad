<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('notes/create','CreateNoteController@store');
Route::delete('notes/delete/{noteId}/{notepadId}','DeleteNoteController@destroy');

Route::get('notes/list','ListNoteController@list');
Route::get('notes/qtdFromUser/{userId}','GetNumberNotesFromUserController@qtdFromUser');

Route::post('users/create','CreateUserController@store');

Route::post('notepad/create','CreateNotepadController@store');


