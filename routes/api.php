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

Route::get('/todos', function () {
//    return \App\Task::latest()->get();
    return response()->json([
        ['id'=>1,'title'=> 'jsksljdklsjdklasja', 'completed'=> false],
        ['id'=>2,'title'=> 'jskscnmvnkljljfsjflsa', 'completed'=> false],
    ]);
})->middleware('cors:api');
