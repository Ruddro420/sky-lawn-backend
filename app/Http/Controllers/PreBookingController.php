<?php

namespace App\Http\Controllers;

use App\Models\PreBooking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PreBookingController extends Controller
{
    public function room_prebook()
    {
        $prebook = PreBooking::all();
       return response()->json([
            'status' => 'success',
            'message' => 'Prebooking data',
            'data' => $prebook
        ]);
        
    }

    public function prebook_add(Request $request)
    {
        $data = $request->all();

        if ($data) {
            $room_number = $data['room_number'];

            // Find the room by room number
            $room_status = Room::where('room_number', $room_number)->first();

            // Check if the room was found
            if ($room_status) {
                $room_status->status = 'pre-booking'; // Update the status
                $room_status->save(); // Save the changes
            } else {
                // Handle the case where the room is not found
                return response()->json(['error' => 'Room not found!']);
            }
        } else {
            // Handle the case where $data is not provided
            return response()->json(['error' => 'Invalid data provided!']);
        }

        // Create the record
        try {

            $prebook = PreBooking::create($data);
            return response()->json([
                'success' => true,
                'message' => 'Prebooking created successfully',
                'data' => $prebook,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create record',
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
