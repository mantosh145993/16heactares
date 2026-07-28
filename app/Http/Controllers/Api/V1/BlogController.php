<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //  LIST BLOGS
    public function index(Request $request)
    {
        $blogs = Blog::where('status', 'published')
            ->latest()
            ->paginate(10);
        //  Fix image URL
        $blogs->getCollection()->transform(function ($blog) {
            $blog->featured_image = $blog->featured_image
                ? asset('storage/' . $blog->featured_image)
                : null;
            return $blog;
        });
        return response()->json([
            'status' => true,
            'message' => 'Blogs fetched successfully',
            'data' => $blogs
        ]);
    }

    //  BLOG DETAIL (SEO FRIENDLY)
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
        // Fix image
        $blog->featured_image = $blog->featured_image
            ? asset('storage/' . $blog->featured_image)
            : null;
        return response()->json([
            'status' => true,
            'message' => 'Blog details',
            'data' => [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'excerpt' => $blog->excerpt,
                'content' => $blog->content,
                'featured_image' => $blog->featured_image,
                'meta_title' => $blog->meta_title,
                'meta_description' => $blog->meta_description,
                'published_at' => $blog->published_at,
                'author' => [
                    'name' => $blog->author?->name,
                ],
            ]
        ]);
    }
}
