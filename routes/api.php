<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsApiController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;
use PharIo\Manifest\Author;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//First tutorial
Route::get('/posts', [PostsApiController::class, 'index']);
Route::post('/posts', [PostsApiController::class, 'save']);
Route::put('/posts/{post}', [PostsApiController::class, 'update']);
Route::delete('/posts/{post}', [PostsApiController::class, 'destroy']);

//Second tutorial
// Route::get('/notes', 'NotesController@index');
// Route::get('/notes', 'NotesController@show');
// Route::post('/notes', 'NotesController@store');
// Route::put('/notes', 'NotesController@update');
// Route::delete('/notes', 'NotesController@delete');
Route::resource('notes', 'NotesController');

//Third tutorial API with authentication
//What i've would dont by my self, spliting the routes into
//2 group using de ::resource method ->middleware('auth') for the
//privates one (that are inside the resource scope)

//Public routes
//Route::resource('products', 'ProductController');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::get('/products/{id}', [ProductController::class, 'show']);

//Protected routes with Sanctum authentication
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

//Route::middleware('auth:sanctum')->get('/products/search/{name}', [ProductController::class, 'search']);

//OR could use but this one seems nastier to me
// Route::group(['middleware' => ['auth:sanctum']], function() {
//     Route::get('/products/search/{name}', [ProductController::class, 'search']);
// });