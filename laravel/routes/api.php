<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckToken;

Route::get('/test', 'TestController@test');
Route::post('/user/signin', 'UserController@signin');

Route::middleware([CheckToken::class])->group(function () {
    Route::get('/user/auth', 'UserController@auth');

    Route::get('/users', 'UserController@getUsers');
    Route::get('/user', 'UserController@getUser');
    Route::post('/user', 'UserController@postUser');
    Route::put('/user', 'UserController@putUser');
    Route::delete('/user', 'UserController@deleteUser');

    Route::get('/categories', 'CategoryController@getCategories');
    Route::get('/category', 'CategoryController@getCategory');
    Route::post('/category', 'CategoryController@postCategory');
    Route::put('/category', 'CategoryController@putCategory');
    Route::delete('/category', 'CategoryController@deleteCategory');

    Route::get('/tags', 'TagController@getTags');
    Route::get('/tag', 'TagController@getTag');
    Route::post('/tag', 'TagController@postTag');
    Route::put('/tag', 'TagController@putTag');
    Route::delete('/tag', 'TagController@deleteTag');

    Route::get('/tasks', 'TaskController@getTasks');
    Route::get('/task', 'TaskController@getTask');
    Route::post('/task', 'TaskController@postTask');
    Route::put('/task', 'TaskController@putTask');
    Route::delete('/task', 'TaskController@deleteTask');

    Route::put('/user/update/room_id', 'UserController@updateRoomId');
    Route::delete('/user/delete', 'UserController@delete');

    Route::post('/work/create', 'WorkController@create');
    Route::get('/work/read/calendar', 'WorkController@read_calendar');
    Route::post('/work/read/analytics', 'WorkController@read_analytics');
    Route::delete('/work/delete', 'WorkController@delete');

    Route::post('/room/create', 'RoomController@create');

    Route::post('/invitation/create', 'InvitationController@create');
    Route::put('/invitation/update', 'InvitationController@update');
    Route::delete('/invitation/delete', 'InvitationController@delete');
});