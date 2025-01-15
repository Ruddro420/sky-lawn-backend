<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Room;
use App\Models\RoomCategory;
use App\Http\Controllers\RoomController;

//Room routing
Route::get('/room',  [RoomController::class, 'room']); // Get all room 
Route::get('/room/add',  [RoomController::class, 'room_add']); // Get add room 
Route::get('/room/delete',  [RoomController::class, 'room_delete']); // Room delete




//RoomCategory routing 
Route::get('/room-category', [RoomController::class, 'category']); // Get all room category
Route::post('/room-category/add', [RoomController::class, 'add_category']); // add room category
Route::get('/room-category/delete/{id}', [RoomController::class, 'delete_category']); // category delete