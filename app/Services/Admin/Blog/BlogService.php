<?php

namespace App\Services\Admin\Blog;

use App\Http\Resources\Admin\BlogCategoryResource;
use App\Models\Admin\Blog;
use Illuminate\Support\Str;
use App\Traits\HttpResponses;
use App\Http\Resources\Admin\BlogResource;
use App\Models\Admin\BlogCategory;
use App\Services\Upload\UploadService;

class BlogService
{
    use HttpResponses;

    public function blogCreate($request)
    {
        try {

            $slug = Str::slug($request->title);

            if (Blog::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . uniqid();
            }

            $data = null;

            if ($request->hasFile('featured_photo')){
                $file = $request->file('featured_photo');
                $folder = 'blog';

                $data = (new UploadService($folder, $file))->run();
            }

            Blog::create([
                'title' => $request->title,
                'blog_category_id' => $request->category_id,
                'slug' => $slug,
                'description' => $request->description,
                'content' => $request->content,
                'tags' => $request->tags,
                'featured_photo' => $data->url ?? $data,
                'file_id' => $data->file_id ?? null,
                'publish_date' => $request->publish_date,
                'status' => $request->status
            ]);

            return $this->success(null, "Created successfully");
        } catch (\Exception $e) {
            return $this->error(null, 500, $e->getMessage());
        }
    }

    public function getAll()
    {
        $perPage = request()->query('per_page', 25);
        $blogs = Blog::with('blogcategory')->paginate($perPage);
        $data = BlogResource::collection($blogs);

        return [
            'status' => true,
            'message' => "Blog Lists",
            'value' => [
                'result' => $data,
                'current_page' => $blogs->currentPage(),
                'page_count' => $blogs->lastPage(),
                'page_size' => $blogs->perPage(),
                'total_records' => $blogs->total()
            ]
        ];
    }

    public function getOne($id)
    {
        $blog = Blog::findOrFail($id);
        $data = new BlogResource($blog);

        return [
            'status' => true,
            'message' => "Blog Details",
            'value' => $data
        ];
    }

    public function editBlog($request, $id)
    {
        $blog = Blog::findOrFail($id);
        try {

            $slug = Str::slug($request->title);

            if (Blog::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . uniqid();
            }

            $data = null;

            if ($request->hasFile('featured_photo')){
                $file = $request->file('featured_photo');
                $folder = 'blog';

                $data = (new UploadService($folder, $file))->run();

            } else {
                $data = [
                    'url' => $blog->featured_photo,
                    'file_id' => $blog->file_id
                ];
            }

            $blog->update([
                'title' => $request->title,
                'slug' => $slug,
                'description' => $request->description,
                'content' => $request->content,
                'tags' => $request->tags,
                'featured_photo' => $data['url'] ?? $data->url ?? $data,
                'file_id' => $data['file_id'] ?? $data->file_id ?? null,
                'publish_date' => $request->publish_date,
                'status' => $request->status
            ]);

            return $this->success(null, "Updated successfully");
        } catch (\Exception $e) {
            return $this->error(null, 500, $e->getMessage());
        }
    }

    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return $this->success(null, "Blog deleted successfully");
    }

    public function count()
    {
        $data = Blog::count();

        return [
            'status' => true,
            'message' => "All Blogs",
            'value' => $data
        ];
    }

    public function blogCatCreate($request)
    {
        try {

            BlogCategory::create([
                'name' => $request->name
            ]);

            return $this->success(null, "Created successfully");
        } catch (\Exception $e) {
            return $this->error(null, 500, $e->getMessage());
        }
    }

    public function getAllCategory()
    {
        $categories = BlogCategory::get();
        $data = BlogCategoryResource::collection($categories);

        return [
            'status' => true,
            'message' => "Blog Categories",
            'value' => $data
        ];
    }
}


