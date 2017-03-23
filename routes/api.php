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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/todos', function () {
    return \App\Task::all();
//    return response()->json([
//        ['id'=>1,'title'=> 'jsksljdklsjdklasja', 'completed'=> false],
//        ['id'=>2,'title'=> 'jskscnmvnkljljfsjflsa', 'completed'=> false],
//    ]);
})->middleware('cors:api');

Route::post('/todo/create', function (Request $request) {
    return $todo = \App\Task::create($request->all());
})->middleware('api','cors');

Route::get('/todo/{id}', function ($id) {
    return \App\Task::find($id);
})->middleware('api','cors');

Route::patch('/todo/{id}/completed', function ($id) {
    $todo = \App\Task::find($id);
    $todo->completed = !$todo->completed;
    $todo->save();
    return $todo;
})->middleware('api','cors');

Route::delete('/todo/{id}/delete', function ($id) {
    $todo = \App\Task::find($id);
    $todo->delete();
    return response()->json(['deleted']);
})->middleware('api','cors');


