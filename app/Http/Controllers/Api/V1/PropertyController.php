<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    //  List Properties
//     public function index()
//     {
//         $properties = Property::with(['images', 'owner', 'agent'])
//             ->latest()
//             ->paginate(10);
//         return response()->json([
//             'status' => true,
//             'message' => 'Property list fetched',
//             'data' => $properties
//         ]);
//     }

public function index(Request $request)
{
    $query = Property::with(['images', 'owner', 'agent']);
    // Filter by city
    if ($request->filled('city')) {
        $query->where('city', $request->city);
    }
    // Filter by type (sale/rent)
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }
    // Filter by property type
    if ($request->filled('property_type')) {
        $query->where('property_type', $request->property_type);
    }
    // Price range
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }
    //  Bedrooms
    if ($request->filled('bedrooms')) {
        $query->where('bedrooms', $request->bedrooms);
    }
    // Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    // Search (title + description)
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }
    if ($request->filled('sort_by')) {
        $query->orderBy($request->sort_by, $request->get('order', 'asc'));
    }
    // Pagination
    $properties = $query->latest()->paginate(10);
    //  image URLs
    $properties->getCollection()->transform(function ($property) {
        $property->images->transform(function ($img) {
            $img->image_url = asset('storage/' . $img->image_url);
            return $img;
        });
        return $property;
    });

    return response()->json([
        'status' => true,
        'message' => 'Filtered properties fetched',
        'data' => $properties
    ]);
}

    //  Single Property
   public function show($id)
   {
       $property = Property::with(['images', 'owner', 'agent'])
           ->findOrFail($id);
       //  Separate featured image
       $featuredImage = $property->images->where('is_featured', true)->first();
       //  Format gallery
       $gallery = $property->images->map(function ($img) {
           return [
               'url' => asset('storage/' . $img->image_url),
               'is_featured' => (bool) $img->is_featured,
           ];
       });
       return response()->json([
           'status' => true,
           'message' => 'Property details fetched',
           'data' => [
               //  BASIC INFO
               'id' => $property->id,
               'title' => $property->title,
               'slug' => $property->slug,
               'description' => $property->description,
               //  PRICE
               'price' => $property->price,
               'formatted_price' => '₹' . number_format($property->price),
               //  TYPE
               'type' => $property->type,
               'property_type' => $property->property_type,
               'status' => $property->status,
               //  DETAILS
               'bedrooms' => $property->bedrooms,
               'bathrooms' => $property->bathrooms,
               'area' => $property->area,
               //  LOCATION
               'address' => $property->address,
               'city' => $property->city,
               'state' => $property->state,
               'country' => $property->country,
               'latitude' => $property->latitude,
               'longitude' => $property->longitude,
               //  IMAGES
               'featured_image' => $featuredImage
                   ? asset('storage/' . $featuredImage->image_url)
                   : null,
               'gallery' => $gallery,
               //  OWNER
               'owner' => $property->owner ? [
                   'id' => $property->owner->id,
                   'name' => $property->owner->name,
                   'phone' => $property->owner->phone,
                   'email' => $property->owner->email,
               ] : null,
               //  AGENT
               'agent' => $property->agent ? [
                   'id' => $property->agent->id,
                   'name' => $property->agent->name,
                   'phone' => $property->agent->phone,
                   'email' => $property->agent->email,
               ] : null,
               //  META
               'created_at' => $property->created_at,
           ]
       ]);
   }

   public function showBySlug($slug)
   {
       $property = Property::where('slug', $slug)
           ->with(['images', 'owner', 'agent'])
           ->firstOrFail();
       return response()->json([
           'status' => true,
           'data' => $property
       ]);
   }
}
