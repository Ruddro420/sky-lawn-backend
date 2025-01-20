<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class RoomBooking extends Controller
{
    public function room_booking()
    {
        $data = Booking::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Booking data',
            'data' => [$data]
        ]);
    }

    public function booking_add(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'user_id' => 'nullable|string',
            'name' => 'nullable|string',
            'mobile' => 'nullable|string',
            'fathers_name' => 'nullable|string',
            'mothers_name' => 'nullable|string',
            'address' => 'nullable|string',
            'nationality' => 'nullable|string',
            'profession' => 'nullable|string',
            'company' => 'nullable|string',
            'comming_form' => 'nullable|string',
            'purpose' => 'nullable|string',
            'checking_date_time' => 'nullable|string',
            'checkout_date_time' => 'nullable|string',
            'room_category' => 'nullable|string',
            'room_number' => 'nullable|string',
            'room_price' => 'nullable|string',
            'person' => 'nullable|string',
            'duration_day' => 'nullable|string',
            'total_price' => 'nullable|string',
            'nid_no' => 'nullable|string',
            'nid_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'couple_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'passport_no' => 'nullable|string',
            'passport_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'visa_no' => 'nullable|string',
            'visa_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'other_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'advance' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'check_status' => 'nullable|string',
            'status' => 'nullable|string',
            'invoice' => 'nullable|string',
        ]);
    
        // Handle file uploads
        if ($request->hasFile('nid_doc')) {
            $validated['nid_doc'] = $request->file('nid_doc')->store('documents');
        }
        if ($request->hasFile('couple_doc')) {
            $validated['couple_doc'] = $request->file('couple_doc')->store('documents');
        }
        if ($request->hasFile('passport_doc')) {
            $validated['passport_doc'] = $request->file('passport_doc')->store('documents');
        }
        if ($request->hasFile('visa_doc')) {
            $validated['visa_doc'] = $request->file('visa_doc')->store('documents');
        }
        if ($request->hasFile('other_doc')) {
            $validated['other_doc'] = $request->file('other_doc')->store('documents');
        }
    
        // Create the booking
        $booking = Booking::create($validated);
    
        // Return JSON response
        return response()->json($booking, 201);
    }

    public function booking_delete($id)
    {
        $booking = Booking::find($id);
        if ($booking) {
            $booking->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Booking deleted'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Booking not found'
            ], 404);
        }
    }
    
}
