<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Property;

class WishlistController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id'
        ]);
        $user = $request->user();
        // Check already exists
        $exists = Wishlist::where('user_id', $user->id)
            ->where('property_id', $request->property_id)
            ->exists();
        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Property already in wishlist'
            ]);
        }
        Wishlist::create([
            'user_id' => $user->id,
            'property_id' => $request->property_id
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Property added to wishlist'
        ]);
    }
    public function list(Request $request)
    {
        $user = $request->user();
        $wishlist = Wishlist::with('property.images')
            ->where('user_id', $user->id)
            ->latest()
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Wishlist fetched successfully',
            'data' => $wishlist
        ]);
    }
    public function remove(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id'
        ]);
        $user = $request->user();
        Wishlist::where('user_id', $user->id)
            ->where('property_id', $request->property_id)
            ->delete();
        return response()->json([
            'status' => true,
            'message' => 'Property removed from wishlist'
        ]);
    }
}
