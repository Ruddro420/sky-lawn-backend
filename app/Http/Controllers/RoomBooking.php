<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\PreBooking;
use Illuminate\Support\Str;

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
        // Generate random user ID and invoice
        $data = $request->all();
        $data['user_id'] = Str::random(10); // Generate random user ID
        $data['invoice'] = Str::random(10); // Generate random invoice number
    
        // Validate incoming request
        $validated = $request->validate([
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
            'passport_no' => 'nullable|string',
            'visa_no' => 'nullable|string',
            'advance' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'check_status' => 'nullable|string',
            'status' => 'nullable|string',
            'nid_doc.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Multiple file validation
        ]);
    
        // Handle room and prebooking status
        if (!empty($validated['room_number'])) {
            $room_number = $validated['room_number'];
            $room_status = Room::where('room_number', $room_number)->first();
            $prebooking_status = PreBooking::where('room_number', $room_number)->first();
    
            if ($prebooking_status) {
                $prebooking_status->status = '1'; // Mark prebooking as completed
                $prebooking_status->save();
            } else {
                return response()->json(['error' => 'Prebooking not found!'], 404);
            }
    
            if ($room_status) {
                $room_status->status = 'booking'; // Update room status to "booking"
                $room_status->save();
            } else {
                return response()->json(['error' => 'Room not found!'], 404);
            }
        } else {
            return response()->json(['error' => 'Room number is required!'], 400);
        }
    
        // Handle document uploads
        if ($request->hasFile('nid_doc')) {
            $files = $request->file('nid_doc');
            $filenames = [];
    
            foreach ($files as $file) {
                $filename = date('Ymdhi') . '_' . $file->getClientOriginalName();
                $file->move(public_path('nid/doc'), $filename); // Save files to 'public/nid/doc' directory
                $filenames[] = $filename;
            }
    
            // Store filenames as JSON string in the database
            $data['nid_doc'] = json_encode($filenames);
        }
    
        // Add user_id and invoice to the validated data
        $validated['user_id'] = $data['user_id'];
        $validated['invoice'] = $data['invoice'];
    
        if (isset($data['nid_doc'])) {
            $validated['nid_doc'] = $data['nid_doc'];
        }
    
        // Create the booking record
        try {
            $booking = Booking::create($validated);
            return response()->json($booking, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create booking', 'message' => $e->getMessage()], 500);
        }
    }


    public function booking_data($id)
    {
        $booking = Booking::find($id);
        if ($booking) {
            return response()->json([
                'status' => 'success',
                'message' => 'Booking found',
                'data' => $booking
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Booking not found'
            ], 404);
        }
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

    // public function find_id($id)
    // {
    //     $booking = Booking::find($id);
    //     if ($booking) {
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Booking found',
    //             'data' => $booking
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Booking not found'
    //         ], 404);
    //     }
    // }
    
}
