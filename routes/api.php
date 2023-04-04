<?php

use App\Http\Controllers\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/* Route::get('studentlist',function(){
    return 'This is API 10';
}); */

Route::get('student',[StudentController::class , 'index']);
Route::post('createStudent', [StudentController::class, 'store']);
Route::get('student/{id}', [StudentController::class, 'show']);
Route::get('student/{id}/edit',[StudentController::class, 'edit']);
Route::put('student/{id}/edit',[StudentController::class, 'update']);
Route::delete('student/{id}/delete',[StudentController::class, 'destory']);