<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    // STORE INQUIRY

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email',
            'phone' => 'required|string|max:15',
            'message' => 'nullable|string',
            'property_id' => 'nullable|exists:properties,id',
        ]);

        $inquiry = Inquiry::create([
            'property_id' => $request->property_id,
            'user_id' => auth()->id(), // optional
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'status' => 'new',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Inquiry submitted successfully',
            'data' => $inquiry,
        ]);
    }
}
