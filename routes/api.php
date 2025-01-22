<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PreBookingController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomBooking;
use App\Http\Controllers\SuportController;
use App\Http\Controllers\ReportController;

//------------------------
//User routing
//------------------------
Route::get('/user', [UserRegisterController::class, 'user_data']); // user data
Route::post('/user/add', [UserRegisterController::class, 'add_user']); // add user
Route::get('/user/delete/{id}', [UserRegisterController::class, 'delete_user']); // delete user
Route::post('/user/check', [UserRegisterController::class, 'checking_user']); // delete user


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
Route::get('/room/available-room',  [RoomController::class, 'available_room']); // Room available (done)
Route::post('/room/update/status',  [RoomController::class, 'status_update']); // Room update status
Route::post('/room/update',  [RoomController::class, 'room_update']); // Room update 


//------------------------
//Prebooking routing
//------------------------
Route::get('/prebook-data', [PreBookingController::class, 'room_prebook']); // Get all prebook data
Route::post('/prebook/add', [PreBookingController::class, 'prebook_add']);  // Add prebook data
Route::delete('/prebook/delete/{id}', [PreBookingController::class, 'prebook_delete']); // Delete prebook data
Route::get('/prebook-data/show/{id}', [PreBookingController::class, 'prebook_data']); // Get all prebook data


//------------------------
//Booking routing
//------------------------
Route::get('/booking-data', [RoomBooking::class, 'room_booking']); // Get all booking data
Route::post('/booking/add', [RoomBooking::class, 'booking_add']); // Add booking data
Route::get('/booking/delete/{id}', [RoomBooking::class, 'booking_delete']); // Delete booking data
Route::get('/booking-data/show/{id}', [RoomBooking::class, 'booking_data']); // Get all booking data


//------------------------
//suport routing 
//------------------------
Route::get('/suport-data', [SuportController::class, 'suport']); // Get all suport data
Route::post('/suport/add', [SuportController::class, 'suport_add']); // Add suport data
Route::get('/suport/delete/{id}', [SuportController::class, 'suport_delete']); // Delete suport data



//------------------------
//Report routing 
//------------------------
Route::get('/booking/report/weekly', [ReportController::class, 'weekly_booking']); // Get all report data
Route::get('/booking/report/monthly', [ReportController::class, 'monthly_booking']); // Get all report data

Route::get('/pre-booking/report/weekly', [ReportController::class, 'weekly_pre_booking']); // Get all report data
Route::get('/pre-booking/report/monthly', [ReportController::class, 'monthly_monthly_booking']); // Get all report data

Route::post('/date/range/report', [ReportController::class, 'date_range_report']); // Get all report data