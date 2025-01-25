<?php

namespace App\Http\Controllers;

use App\Models\PreBooking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class PreBookingController extends Controller
{
    public function room_prebook()
    {
        $prebook = PreBooking::orderBy('created_at', 'desc')->get();

       return response()->json([
            'status' => 'success',
            'message' => 'Prebooking data',
            'data' => $prebook
        ]);
        
    }

    public function prebook_add(Request $request)
    {
        $data = $request->all();
    
        // Ensure data is provided
        if (!$data) {
            return response()->json(['error' => 'Invalid data provided!'], 400);
        }
    
        $room_number = $data['room_number'];
        $prebook_data = $data['date_time']; // Provided date_time for prebooking
        $prebook_date = Carbon::parse($prebook_data)->toDateString(); // Extract the date only (format: Y-m-d)
    
        // Find the room by room number
        $room_status = Room::where('room_number', $room_number)->first();
    
        if (!$room_status) {
            return response()->json(['error' => 'Room not found!'], 404);
        }
    
        // Check if the room is already booked or pre-booked
        if ($room_status->status == 'pre-booked' || $room_status->status == 'booked') {
            return response()->json([
                'message' => 'Room is already booked!',
            ], 400);
        }
    
        // Check for existing prebooking conflicts on the same date
        $existing_prebook = PreBooking::where('room_number', $room_number)
            ->whereDate('date_time', $prebook_date)
            ->first();
    
        if ($existing_prebook) {
            return response()->json([
                'message' => 'Room is already pre-booked for the specified date!',
            ], 409); // HTTP 409 Conflict
        }
    
        // Update the room status to 'pre-booking'
        $room_status->status = 'pre-booking';
        $room_status->save();
    
        // Create the prebooking record
        try {
            $prebook = PreBooking::create($data);
    
            return response()->json([
                'success' => true,
                'message' => 'Prebooking created successfully.',
                'data' => $prebook,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create record.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function prebook_delete($id)
    {
        // Find the prebooking by ID
        $selectedPrebook = PreBooking::find($id);
    
        // Check if the prebooking exists
        if (!$selectedPrebook) {
            return response()->json([
                'message' => 'Prebooking not found!',
            ], 404);
        }
    
        // Find the room by room number
        $roomNumber = $selectedPrebook->room_number;
        $room = Room::where('room_number', $roomNumber)->first();
    
        if ($room) {
            // Update room status to 'available' if the room exists
            $room->status = 'available';
            $room->save();
        } else {
            // If the room is not found, return an error response or log the issue
            return response()->json([
                'message' => 'Room not found for the prebooking!',
            ], 404);
        }
    
        // Delete the prebooking
        $selectedPrebook->delete();
    
        return response()->json([
            'message' => 'Prebooking deleted successfully and room status updated to available.',
        ]);
    }
    

    public function prebook_data($id)
    {
        // Find the room by ID
        $selected_prebook = PreBooking::find($id);

        // Check if the room exists
        if (!$selected_prebook) {
            return response()->json([
                'message' => 'Prebooking not found!',
            ], 404);
        }

        return response()->json($selected_prebook);
    }
}
