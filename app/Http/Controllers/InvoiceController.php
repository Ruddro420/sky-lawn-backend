<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\Booking;

class InvoiceController extends Controller
{
    public function invoice()
    {
        $invoice = Invoice::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Invoice data',
            'data' => $invoice
        ]);
    }

    public function invoice_add(Request $request)
    {
        // Validate the input
        $request->validate([
            'invoice' => 'required|unique:invoices,invoice',
        ]);
    
        // Get all request data
        $data = $request->all();
    
        // Find the room by room number
        $roomNumber = $data['room_type'];
        $room = Room::where('room_number', $roomNumber)->first();
    
        // Find the booking by booking ID
        $bookingId = $data['booking_id'];
        $booking = Booking::where('user_id', $bookingId)->first();
    
        // Check if booking exists
        if ($booking) {
            $booking->check_status = '0';
            $booking->save();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found!',
            ], 404);
        }
    
        // Check if room exists
        if ($room) {
            // Update room status to 'available'
            $room->status = 'available';
            $room->save();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Room not found!',
            ], 404);
        }
    
        // Create the invoice record
        try {
            $invoice = Invoice::create($data);
    
            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully!',
                'data' => $invoice,
            ], 201);
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return response()->json([
                'success' => false,
                'message' => 'Failed to create the invoice!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    public function invoice_delete($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            $invoice->delete();
            return response()->json([
                'success' => true,
                'message' => 'Invoice deleted successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invoice not found',
            ], 404);
        }
    }
}
