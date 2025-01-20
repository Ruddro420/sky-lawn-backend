<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suport;

class SuportController extends Controller
{
    public function suport()
    {
        $suport = Suport::all();
        return response()->json([
            'success' => true,
            'message' => 'Welcome to the Suport page',
            'data' => [$suport]
        ]);
    }

    public function suport_add(Request $request)
    {
        $data = $request->all();

        // Create the record
        try {
            $suport = Suport::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Suport created successfully',
                'data' => $suport,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function suport_delete($id)
    {
        try {
            $suport = Suport::findOrFail($id);
            $suport->delete();

            return response()->json([
                'success' => true,
                'message' => 'Suport deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
