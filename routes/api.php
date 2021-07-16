<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypeClientController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();

// });

Route::group(['middleware' => 'auth:api'],function (){
   
});


Route::get('/user/list',[UserController::class,'index']);
Route::get('/user/list',[UserController::class,'index']);
Route::post('/user/register',[UserController::class,'register']);
Route::post('/user/login',[UserController::class,'login']);
Route::get('/user/logout',[UserController::class,'logout']);
Route::patch('/user/update/{user}',[UserController::class,'update']);
Route::delete('/user/delete/{user}',[UserController::class,'destroy']);

Route::get('/role/list',[RoleController::class,'index']);
Route::post('/role/store',[RoleController::class,'store']);
Route::get('/role/show/{role}',[RoleController::class,'show']);
Route::patch('/role/update/{role}',[RoleController::class,'update']);
Route::delete('/role/delete/{role}',[RoleController::class,'delete']);


Route::get('/category/list',[CategoryController::class,'index']);
Route::post('/category/store',[CategoryController::class,'store']);
Route::get('/category/show/{category}',[CategoryController::class,'show']);
Route::patch('/category/update/{category}',[CategoryController::class,'update']);
Route::delete('/category/delete/{category}',[CategoryController::class,'delete']);

Route::get('/product/list',[ProductController::class,'index']);
Route::post('/product/store',[ProductController::class,'store']);
Route::get('/product/show/{product}',[ProductController::class,'show']);
Route::put('/product/update/{product}',[ProductController::class,'update']);
Route::delete('/product/delete/{product}',[ProductController::class,'delete']);
Route::get('/product/search/{product}',[ProductController::class,'search']);
Route::get('/product/productByCategory/{category}',[ProductController::class,'getProductByCategory']);
Route::get('/product/productByDisponible/{disponibilite}',[ProductController::class,'getProductByDisponible']);
Route::get('/product/productByCategoryByDis/{category}/{dispo}',[ProductController::class,'getProductByCategoryAndDispo']);

Route::get('/type_client/list',[TypeClientController::class,'index']);
Route::post('/type_client/store',[TypeClientController::class,'store']);
Route::get('/type_client/show/{type}',[TypeClientController::class,'show']);
Route::put('/type_client/update/{id}',[TypeClientController::class,'update']);
Route::delete('/type_client/delete/{typeclient}',[TypeClientController::class,'destroy']);
Route::get('/type_client/search/{key}',[TypeClientController::class,'search']);

Route::get('/client/list',[ClientController::class,'index']);
Route::post('/client/store',[ClientController::class,'store']);
Route::get('/client/show/{client}',[ClientController::class,'show']);
Route::post('/client/check-client',[ClientController::class,'checkClient']);