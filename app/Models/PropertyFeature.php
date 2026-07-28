<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PropertyFeature extends Pivot
{
    protected $table = 'property_feature';

    protected $fillable = [
        'property_id',
        'feature_id'
    ];
}
