<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    //---------------------------------------------------------------------
    //  Room  controlling 
    //---------------------------------------------------------------------

    //get room
    public function rooms()
    {
        $rooms = Room::with('category')->get(); // Load Room with related Category
        return response()->json($rooms);
    }

    //add room
    public function room_add(Request $request)
    {
        $data = $request->all();

        $roomNumber = $data['room_number'];
        
        $findRoom = Room::where('room_number', $roomNumber)->first();

        if(empty($findRoom)) {

        // Create the record
        try {
            $room = Room::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Room created successfully',
                'data' => $room,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create record',
                'error' => $e->getMessage(),
            ], 500);
        }

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Room already Added'
            
            ], 303);
        }
        


    }

    //delete room
    public function room_delete($id)
    {
        // Find the room by ID
        $selected_room = Room::find($id);

        // Check if the room exists
        if (!$selected_room) {
            return response()->json([
                'message' => 'Room not found!',
            ], 404);
        }

        // Delete the room
        $selected_room->delete();

        return response()->json([
            'message' => 'Room deleted successfully!',
        ], 200);
    }

    //edit room
    public function room_edit($id)
    {
        $room = Room::find($id);
        return response()->json($room);
    }

    //room update 
    public function room_update(Request $request)
    {
        // Find the room by ID
        $room = Room::find($request->id);
    
        // Ensure the room exists
        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Room not found.',
            ], 404);
        }
    
        // Update only the fields present in the request
        $room->fill($request->only([
            'room_number',
            'room_name',
            'room_category_id',
            'price',
            'feature',
            'status'
        ]));
    
        // Save the changes
        $room->save();
    
        // Return a JSON response with the updated room
        return response()->json([
            'success' => true,
            'message' => 'Room updated successfully.',
            'data' => $room,
        ], 200);
    }
    
    
    
    public function room_price($id)
    {
        $room = Room::find($id);
        $roomdata = [
            'room_name' => $room->room_number,
            'price' => $room->price
        ];

        return response()->json($roomdata);
    }

    // Fetch all available rooms
    public function available_room(): JsonResponse
    {
        $rooms = Room::where(function ($query) {
            $query->where('status', 'available')
                  ->orWhere('status', 'pre-booking');
        })->with('category')->get();
        
        return response()->json($rooms, 200);
    }

    //Romm status update
    public function status_update(Request $request)
    {
        $room = Room::find($request->id);
        $room->status = $request->status;
        $room->save();
        return response()->json($room, 200);
    }

    //---------------------------------------------------------------------
    //  Room category controlling 
    //---------------------------------------------------------------------

    // Get all room categories
    public function category()
    {
        $categories = RoomCategory::all();
        return response()->json($categories);
    }

    // add category
    public function add_category(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:room_categories,name',
        ]);
        $data = new RoomCategory();
        $data->name = $request->name;
        $data->save();
        return 'Category Added Done';
    }

    public function delete_category($id)
    {
        // Find the category by ID
        $selected_category = RoomCategory::find($id);

        // Check if the category exists
        if (!$selected_category) {
            return response()->json([
                'message' => 'Category not found!',
            ], 404);
        }

        // Delete the category
        $selected_category->delete();

        return response()->json([
            'message' => 'Category deleted successfully!',
        ], 200);
    }


}
