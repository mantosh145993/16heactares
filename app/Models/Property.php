<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyImage;

class Property extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'price',
        'type', 'property_type',
        'bedrooms', 'bathrooms', 'area',
        'address', 'city', 'state', 'country',
        'latitude', 'longitude',
        'status', 'owner_id', 'agent_id'
    ];

    //  Relationships
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'property_feature');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }
}
