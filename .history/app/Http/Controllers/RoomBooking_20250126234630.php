<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\PreBooking;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

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
        // Generate random user ID and invoice number
        $data = $request->all();
        $data['user_id'] = Str::random(10); // Generate random user ID
        $data['invoice'] = Str::random(10); // Generate random invoice number

        $room_number = $data['room_number'];
        $checking_data = $data['checking_date_time']; // Provided date_time for checking
        $checking_date = Carbon::parse($checking_data)->toDateString(); // Generate checking date

        // Check for existing booking conflicts on the same date
        $existing_booking = Booking::where('room_number', $room_number)
            ->whereDate('checking_date_time', $checking_date)
            ->first();

        if ($existing_booking) {
            return response()->json(['message' => 'Room is already booked for the specified date!'], 409);
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
            'couple_doc.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'visa_doc.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'other_doc.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'nid_doc.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Handle room and prebooking status
        $room_status = Room::where('room_number', $room_number)->first();
        $prebooking_status = PreBooking::where('room_number', $room_number)->first();

        if ($prebooking_status) {
            $prebooking_status->status = '1'; // Mark prebooking as completed
            $prebooking_status->save();
        } else {
            return response()->json(['error' => 'Prebooking not found!'], 404);
        }

        if ($room_status) {
            $room_status->status = 'booking'; // Update room status to "booking"
            $room_status->save();
        } else {
            return response()->json(['error' => 'Room not found!'], 404);
        }

        // Handle document uploads
        // $documents = ['nid_doc', 'couple_doc', 'visa_doc', 'other_doc'];
        // foreach ($documents as $document) {
        //     if ($request->hasFile($document)) {
        //         $files = $request->file($document);
        //         $filenames = [];

        //         foreach ($files as $file) {
        //             $directory = public_path($document . '/doc');
        //             if (!is_dir($directory)) {
        //                 mkdir($directory, 0777, true); // Create directory if it doesn't exist
        //             }

        //             $filename = date('Ymdhi') . '_' . $file->getClientOriginalName();
        //             $file->move($directory, $filename); // Save files in respective directories
        //             $filenames[] = $filename;
        //         }

        //         // Store filenames as JSON string
        //         $validated[$document] = json_encode($filenames);
        //     } else {
        //         $validated[$document] = null; // Set to null if no files uploaded
        //     }
        // }


        $documents = ['nid_doc', 'couple_doc', 'visa_doc', 'other_doc'];
        $validated = [];

        // try {


        //     return response()->json(['message' => 'Files uploaded successfully.', 'data' => $validated], 200);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 500);
        // }


        // Add user_id and invoice to the validated data
        $validated['user_id'] = $data['user_id'];
        $validated['invoice'] = $data['invoice'];

        // Create the booking record
        try {
            foreach ($documents as $document) {
                if ($request->hasFile($document)) {
                    $files = $request->file($document);

                    // Ensure $files is an array
                    if (!is_array($files)) {
                        $files = [$files];
                    }

                    $filenames = [];
                    foreach ($files as $file) {
                        // Validate file type and size
                        if (!$file->isValid() || !in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'application/pdf'])) {
                            return response()->json(['error' => 'Invalid file type.'], 400);
                        }
                        if ($file->getSize() > 2048 * 1024) { // 2MB limit
                            return response()->json(['error' => 'File size exceeds limit.'], 400);
                        }

                        // Create directory if not exists
                        $directory = public_path($document . '/doc');
                        if (!is_dir($directory)) {
                            mkdir($directory, 0755, true);
                        }

                        // Generate unique filename
                        $filename = date('Ymdhi') . '_' . uniqid() . '_' . $file->getClientOriginalName();
                        $file->move($directory, $filename);
                        $filenames[] = $filename;
                    }

                    // Store filenames as JSON string
                    $validated[$document] = json_encode($filenames);
                    $booking = Booking::create($validated);
                    return response()->json($booking, 201);
                } else {
                    $validated[$document] = null; // Set to null if no files uploaded
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create booking', 'message' => $e->getMessage()], 500);
        }
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
