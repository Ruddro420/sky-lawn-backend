<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Booking::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
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
            'nid_doc' => 'nullable|string',
            'couple_doc' => 'nullable|string',
            'passport_no' => 'nullable|string',
            'passport_doc' => 'nullable|string',
            'visa_no' => 'nullable|string',
            'visa_doc' => 'nullable|string',
            'other_doc' => 'nullable|string',
            'advance' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'check_status' => 'nullable|string',
            'status' => 'nullable|string',
            'invoice' => 'nullable|string',
        ]);

        $booking = Booking::create($data);

        return response()->json($booking, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        return response()->json($booking, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $data = $request->validate([
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
            'nid_doc' => 'nullable|string',
            'couple_doc' => 'nullable|string',
            'passport_no' => 'nullable|string',
            'passport_doc' => 'nullable|string',
            'visa_no' => 'nullable|string',
            'visa_doc' => 'nullable|string',
            'other_doc' => 'nullable|string',
            'advance' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'check_status' => 'nullable|string',
            'status' => 'nullable|string',
            'invoice' => 'nullable|string',
        ]);

        $booking->update($data);

        return response()->json($booking, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully'], 200);
    }
}
