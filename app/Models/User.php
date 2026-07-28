<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;


class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password',
        'role', 'profile_image', 'is_verified'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];


    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true;
    }

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
    //  Relationships
    public function properties()
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    public function agentProperties()
    {
        return $this->hasMany(Property::class, 'agent_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    
     public function wishlistProperties()
    {
        return $this->belongsToMany(Property::class, 'wishlists');
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }
}
