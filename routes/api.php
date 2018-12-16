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

Route::delete('notepad/{notepadId}/note/{noteId}/','DeleteNoteController@destroy');
Route::get('notes/list','ListNoteController@list');

Route::get('user/{userId}/notepad/number-of-notes','GetNumberNotesFromUserController@qtdFromUser');
Route::get('user/{userId}/notepad/notes-from-user','NotesFromUserController@allNotes');

Route::post('user','CreateUserController@store');
Route::post('notepad','CreateNotepadController@store');
Route::post('notepad/{id}/note','CreateNoteController@store');



