<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'excerpt',
        'featured_image', 'author_id',
        'status', 'published_at',
        'meta_title', 'meta_description'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    //  Relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany(
            BlogCategory::class,
            'blog_category_post'
        );
    }
}
