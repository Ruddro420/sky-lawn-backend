<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

//Room routing
Route::get('/room/data',  [RoomController::class, 'room']); // Get all room 
Route::post('/room/add', [RoomController::class, 'add_room']); // add room category
Route::get('/room/delete',  [RoomController::class, 'room_delete']); // Room delete




//RoomCategory routing 
Route::get('/room-category', [RoomController::class, 'category']); // Get all room category
Route::post('/room-category/add', [RoomController::class, 'add_category']); // add room category
Route::get('/room-category/delete/{id}', [RoomController::class, 'delete_category']);
