<?php

use App\Http\Controllers\PreBookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

//------------------------
//User routing
//------------------------
Route::get('/user', [RoomController::class, 'category']); // user data
Route::post('/user/add', [RoomController::class, 'add_category']); // add user
Route::get('/user/delete/{id}', [RoomController::class, 'delete_category']); // delete user


//------------------------
//RoomCategory routing 
//------------------------
Route::get('/room-category', [RoomController::class, 'category']); // Get all room category (done)
Route::post('/room-category/add', [RoomController::class, 'add_category']); // add room category (done)
Route::get('/room-category/delete/{id}', [RoomController::class, 'delete_category']); // delete room category (done)


//------------------------
//Room routing
//------------------------
Route::get('/room/data',  [RoomController::class, 'rooms']); // Get all room    (done)
Route::post('/room/add', [RoomController::class, 'room_add']); // add room category (done)
Route::get('/room/edit/{id}',  [RoomController::class, 'room_edit']); // Room delete (done)
Route::get('/room/delete/{id}',  [RoomController::class, 'room_delete']); // Room delete (done)
Route::get('/room/room-number/price/{id}',  [RoomController::class, 'room_price']); // Room delete (done)

//------------------------
//Prebooking routing
//------------------------
Route::get('/prebook-data', [PreBookingController::class, 'room_prebook']); // Get all prebook data
Route::post('/prebook/add', [PreBookingController::class, 'prebook_add']);  // Add prebook data
Route::delete('/prebook/delete/{id}', [PreBookingController::class, 'prebook_delete']); // Delete prebook data


