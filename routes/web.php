<?php

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Auth::routes();

Route::patch('tasks/updateOrder', 'TaskController@updateOrder');
Route::patch('tasks/updateFinished/{task}', 'TaskController@updateFinished');
Route::resource('tasks', 'TaskController');
