<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\PreBooking;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Validator;
class RoomBooking extends Controller
{
    public function room_booking()
    {
        $data = Booking::orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Booking data',
            'data' => [$data]
        ]);
    }



    public function booking_add(Request $request)
    {
        $data = $request->all(); // Fetch all incoming data
    
        // Ensure the incoming data is an array of bookings
        if (!isset($data['bookings']) || !is_array($data['bookings'])) {
            return response()->json(['error' => 'Invalid data format. Expected an array of bookings.'], 400);
        }
    
        $results = []; // Store results for each booking record
    
        foreach ($data['bookings'] as $bookingData) {
            try {
                // Generate random user ID and invoice number for each booking
                $bookingData['user_id'] = Str::random(10);
                $bookingData['invoice'] = Str::random(10);
    
                // Extract and parse date
                $room_number = $bookingData['room_number'];
                $checking_data = $bookingData['checking_date_time'];
                $checking_date = Carbon::parse($checking_data)->toDateString();
    
                // Check for existing booking conflicts
                $existing_booking = Booking::where('room_number', $room_number)
                    ->whereDate('checking_date_time', $checking_date)
                    ->first();
    
                if ($existing_booking) {
                    $results[] = [
                        'status' => 'failed',
                        'message' => "Room {$room_number} is already booked for the specified date.",
                    ];
                    continue;
                }
    
                // Validate individual booking data
                $validated = Validator::make($bookingData, [
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
                    'nid_doc.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                    'couple_doc.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                    'visa_doc.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                    'other_doc.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                ])->validate();
    
                // Handle prebooking status
                $prebooking_status = PreBooking::where('room_number', $room_number)->first();
                if ($prebooking_status) {
                    $prebooking_status->status = '1';
                    $prebooking_status->save();
                } else {
                    $results[] = [
                        'status' => 'failed',
                        'message' => "Prebooking not found for room {$room_number}.",
                    ];
                    continue;
                }
    
                // Handle room status
                $room_status = Room::where('room_number', $room_number)->first();
                if ($room_status) {
                    $room_status->status = 'booking';
                    $room_status->save();
                } else {
                    $results[] = [
                        'status' => 'failed',
                        'message' => "Room {$room_number} not found.",
                    ];
                    continue;
                }
    
                // Handle document uploads
                $documents = ['nid_doc', 'couple_doc', 'visa_doc', 'other_doc'];
                foreach ($documents as $document) {
                    if ($request->hasFile($document)) {
                        $files = $request->file($document);
                        $filenames = [];
    
                        foreach ($files as $file) {
                            $directory = public_path($document . '/doc');
                            if (!is_dir($directory)) {
                                mkdir($directory, 0777, true);
                            }
    
                            $filename = date('Ymdhi') . '_' . $file->getClientOriginalName();
                            $file->move($directory, $filename);
                            $filenames[] = $filename;
                        }
    
                        $validated[$document] = json_encode($filenames);
                    } else {
                        $validated[$document] = null;
                    }
                }
    
                // Add user_id and invoice to the validated data
                $validated['user_id'] = $bookingData['user_id'];
                $validated['invoice'] = $bookingData['invoice'];
    
                // Create booking record
                $booking = Booking::create($validated);
                $results[] = [
                    'status' => 'success',
                    'data' => $booking,
                ];
            } catch (\Exception $e) {
                $results[] = [
                    'status' => 'failed',
                    'message' => $e->getMessage(),
                ];
            }
        }
    
        return response()->json($results, 200);
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
