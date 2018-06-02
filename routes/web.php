<?php

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Auth::routes();

Route::patch('tasks/updateOrder', 'TaskController@updateOrder');
Route::resource('tasks', 'TaskController');
