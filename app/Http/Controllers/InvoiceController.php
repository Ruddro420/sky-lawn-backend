<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

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
        $data = $request->all();

        // Create the record
        try {

            $invoice = Invoice::create($data);
            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully',
                'data' => $invoice,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create record',
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
