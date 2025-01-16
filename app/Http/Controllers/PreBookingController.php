<?php

namespace App\Http\Controllers;
use App\Models\PreBooking;
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
