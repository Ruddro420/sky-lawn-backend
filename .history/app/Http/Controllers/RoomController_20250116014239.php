<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomCategory;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Rooms controlling
    public function rooms()
    {
        $rooms = Room::with('category')->get(); // Load Room with related Category
        return response()->json($rooms);
    }

    public function add_room(Request $request)
    {
       return 'hello';
    }

    //  Room category controlling 

    // Get all room categories
    public function category()
    {
        $categories = RoomCategory::all();
        return response()->json($categories);
    }

    // add category
    public function add_category(Request $request)
    {
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
