<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\PreBooking;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;


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

    // Weekly report prebooking
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

    // Monthly report prebooking
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


    public function date_range_report(Request $request)
    {

        // Validate input
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'booking' => 'required|string|in:pre_booking,booking',
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay()->addSecond(); // Ensure end of day is captured
        $bookReport = $request->booking;

        if ($bookReport == 'pre_booking') {
            // Query PreBooking records
            $dateRangeReport = PreBooking::whereBetween('date_time', [$startDate, $endDate])->get();

            $preBookingCount = $dateRangeReport->count();
            $totalPrice = $dateRangeReport->sum('room_price');

            return response()->json([
                'success' => true,
                'message' => 'Pre-booking date range report retrieved successfully.',
                'count' => $preBookingCount,
                'total_price' => $totalPrice,
                'data' => $dateRangeReport,
            ]);
        } elseif ($bookReport == 'booking') {
            // Query Booking records
            $dateRangeReport = Booking::whereBetween('checking_date_time', [$startDate, $endDate])
                ->get();

            $bookingCount = $dateRangeReport->count();
            $totalPrice = $dateRangeReport->sum('room_price');

            return response()->json([
                'success' => true,
                'message' => 'Booking date range report retrieved successfully.',
                'count' => $bookingCount,
                'total_price' => $totalPrice,
                'data' => $dateRangeReport,
            ]);
        } else { 
            // No valid type specified
            return response()->json([
                'success' => false,
                'message' => 'Invalid request. Please specify either pre_booking or booking as true.',
            ], 400);
        }

    }
    public function invoice_report_range(Request $request)
    {
        // Validate input
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
    
        try {
            // Parse dates
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
    
            // Query Invoice records
            $invoices = Invoice::whereBetween('created_at', [$startDate, $endDate])->get();
    
            // Ensure room_price is numeric before summing
            $totalPrice = $invoices->sum(fn ($invoice) => (float) $invoice->final_amount);
    
            return response()->json([
                'success' => true,
                'message' => 'Invoice date range report retrieved successfully.',
                'count' => $invoices->count(),
                'total_price' => $totalPrice,
                'data' => $invoices,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve invoice date range report.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
