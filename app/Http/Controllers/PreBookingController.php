<?php

namespace App\Http\Controllers;

use App\Models\PreBooking;
use App\Models\Room;
use Illuminate\Http\Request;

class PreBookingController extends Controller
{
    public function room_prebook()
    {
        $prebook = PreBooking::all();
        return response()->json($prebook);
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
        // Find the room by ID
        $selected_prebook = PreBooking::find($id);

        // Check if the room exists
        if (!$selected_prebook) {
            return response()->json([
                'message' => 'Prebooking not found!',
            ], 404);
        }

        // Delete the room
        $selected_prebook->delete();

        return response()->json([
            'message' => 'Prebooking deleted successfully',
        ]);
    }
}
