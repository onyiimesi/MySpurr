<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use App\Services\Admin\Blog\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $service;

    public function __construct(BlogService $blogService)
    {
        $this->service = $blogService;
    }

    public function blogCreate(BlogRequest $request)
    {
        return $this->service->blogCreate($request);
    }

    public function getAll()
    {
        return $this->service->getAll();
    }

    public function getOne($id)
    {
        return $this->service->getOne($id);
    }

    public function editBlog(Request $request, $id)
    {
        return $this->service->editBlog($request, $id);
    }

    public function deleteBlog($id)
    {
        return $this->service->deleteBlog($id);
    }
}
