<?php

namespace App\Services\Blog;

use App\Http\Resources\Admin\BlogCategoryResource;
use App\Models\Admin\Blog;
use Illuminate\Support\Str;
use App\Traits\HttpResponses;
use App\Http\Resources\Admin\BlogResource;
use App\Models\Admin\BlogCategory;

class BlogService
{
    use HttpResponses;


    public function getAll()
    {
        $category = request()->query('category');

        $query = Blog::with('blogcategory');

        if ($category && $category !== 'ALL') {
            $query->where('blog_category_id', $category);
        }

        $blogs = $query->orderBy('created_at', 'desc')->paginate(25);
        $data = BlogResource::collection($blogs);

        return [
            'status' => 'true',
            'message' => 'Job List',
            'data' => $data,
            'pagination' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'prev_page_url' => $blogs->previousPageUrl(),
                'next_page_url' => $blogs->nextPageUrl()
            ],
        ];
    }

    public function getOne($id)
    {
        $blog = Blog::findOrFail($id);
        $data = new BlogResource($blog);

        return [
            'status' => true,
            'message' => "Blog Details",
            'data' => $data
        ];
    }

    public function getSlug($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $data = new BlogResource($blog);

        return [
            'status' => true,
            'message' => "Blog Details",
            'data' => $data
        ];
    }

    public function count()
    {
        $data = Blog::count();

        return [
            'status' => true,
            'message' => "All Blogs",
            'data' => $data
        ];
    }

    public function getAllCategory()
    {
        $categories = BlogCategory::get();
        $data = BlogCategoryResource::collection($categories);

        return [
            'status' => true,
            'message' => "Blog Categories",
            'data' => $data
        ];
    }
}


