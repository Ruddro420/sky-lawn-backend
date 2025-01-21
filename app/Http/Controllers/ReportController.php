<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\PreBooking;
use Carbon\Carbon;


class ReportController extends Controller
{

    // Weekly report
    public function weekly_booking()
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Monday
        $endOfWeek = Carbon::now()->endOfWeek();     // Sunday
    
        $weeklyReport = Booking::whereBetween('created_at', [$startOfWeek, $endOfWeek]);
    
        // Count the number of bookings
        $bookingCount = $weeklyReport->count();
    
        // Calculate the total price sum (ensure 'room_price' is numeric)
        $totalPrice = $weeklyReport->sum('room_price');
    
        return response()->json([
            'success' => true,
            'message' => 'Weekly report retrieved successfully.',
            'data' => [
                'count' => $bookingCount,
                'total_price' => $totalPrice,
            ],
        ]);
    }
    

    // Monthly report
    public function monthly_booking()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
    
        $monthlyReport = Booking::whereBetween('created_at', [$startOfMonth, $endOfMonth]);
    
        // Count the number of bookings
        $bookingCount = $monthlyReport->count();
    
        // Calculate the total price sum (ensure 'room_price' is numeric)
        $totalPrice = $monthlyReport->sum('room_price');
    
        return response()->json([
            'success' => true,
            'message' => 'Monthly report retrieved successfully.',
            'data' => [
                'count' => $bookingCount,
                'total_price' => $totalPrice,
            ],
        ]);
    }



    
    // Weekly report
    public function weekly_pre_booking()
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Monday
        $endOfWeek = Carbon::now()->endOfWeek();     // Sunday
    
        $weeklyReport = PreBooking::whereBetween('created_at', [$startOfWeek, $endOfWeek]);
    
        // Count the number of bookings
        $bookingCount = $weeklyReport->count();
    
        // Calculate the total price sum (ensure 'room_price' is numeric)
        $totalPrice = $weeklyReport->sum('room_price');
    
        return response()->json([
            'success' => true,
            'message' => 'Weekly report retrieved successfully.',
            'data' => [
                'count' => $bookingCount,
                'total_price' => $totalPrice,
            ],
        ]);
    }
    

    // Monthly report
    public function monthly_monthly_booking()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
    
        $monthlyReport = PreBooking::whereBetween('created_at', [$startOfMonth, $endOfMonth]);
    
        // Count the number of bookings
        $bookingCount = $monthlyReport->count();
    
        // Calculate the total price sum (ensure 'room_price' is numeric)
        $totalPrice = $monthlyReport->sum('room_price');
    
        return response()->json([
            'success' => true,
            'message' => 'Monthly report retrieved successfully.',
            'data' => [
                'count' => $bookingCount,
                'total_price' => $totalPrice,
            ],
        ]);
    }
    
}
