<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BlogCategoryPost extends Pivot
{
    protected $table = 'blog_category_post';

    protected $fillable = [
        'blog_id',
        'blog_category_id'
    ];
}
