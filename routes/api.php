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

Route::get('/folders', 'FolderController@getFolders');

Route::get('/folder/sub/{id}', 'FolderController@getSubFoldersOfOneFolder');

Route::get('/folder/files/{id}', 'FolderController@getFileOfOneFolder');

Route::get('/folder/{id}', 'FolderController@getOneFolder');

Route::post('/upload', 'FolderController@uploadFile');
