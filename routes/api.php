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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::middleware('auth:api')->group(function (){
//    Route::post('info','InformationController/addPostMessageInfo');
//});
Route::get('/aaa', function () {
    dd(123);
});

//Route::group(['prefix' => '', 'namespace' => '', 'middleware' => ''], function () {
//});
Route::post('/addinfo', 'InformationController@addPostMessageInfo');
Route::post('/getinfo', 'InformationController@getPostMessageInfo');
Route::post('/getinfodetail', 'InformationController@getdetailInfo');
Route::post('/addRecruit', 'InformationController@addRecruitInfo');
Route::post('/uploadimg', 'InformationController@uploadImg');
