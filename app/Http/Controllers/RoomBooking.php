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
        $data = $request->all();
        $data['user_id'] = Str::random(10);  // Generate random user ID
        $data['invoice'] = Str::random(10);  // Generate random invoice number

        // Update room status if room_number is provided
        if (isset($data['room_number'])) {
            $room_number = $data['room_number'];
            $room_status = Room::where('room_number', $room_number)->first();
            $prebooking_status = PreBooking::where('room_number', $room_number)->first();

            // Update prebooking status
            if ($prebooking_status) {
                $prebooking_status->status = '1';
                $prebooking_status->save();
            } else {
                return response()->json(['error' => 'Prebooking not found!'], 404);
            }

            // Update room status
            if ($room_status) {
                $room_status->status = 'booking';
                $room_status->save();
            } else {
                return response()->json(['error' => 'Room not found!'], 404);
            }
        } else {
            return response()->json(['error' => 'Invalid data provided!'], 400);
        }

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
            '_doc.*' => 'nullable|file|mimes:jpg,png,pdf|max:2048', // Multiple file upload
        ]);

        // Handle document uploads
        $files = [];
        $fileFields = ['nid_doc', 'couple_doc', 'passport_doc', 'visa_doc', 'other_doc'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $filePaths = [];
                foreach ($request->file($field) as $file) {
                    // Store each file and add its path to the array
                    $filePaths[] = $file->store('documents');
                }
                // Store the file paths as a JSON string
                $files[$field] = json_encode($filePaths);
            }
        }

        // Merge uploaded files into the validated data
        $validated = array_merge($validated, $files);
        
        // Add user_id and invoice to validated data
        $validated['user_id'] = $data['user_id'];
        $validated['invoice'] = $data['invoice'];

        // Create the booking record
        $booking = Booking::create($validated);

        // Return the created booking
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
