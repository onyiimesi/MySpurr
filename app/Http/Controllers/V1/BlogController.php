<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\Blog\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    protected $service;

    public function __construct(BlogService $blogService)
    {
        $this->service = $blogService;
    }

    public function getAll()
    {
        return $this->service->getAll();
    }

    public function getOne($id)
    {
        return $this->service->getOne($id);
    }

    public function getSlug($slug)
    {
        return $this->service->getSlug($slug);
    }

    public function getAllCategory()
    {
        return $this->service->getAllCategory();
    }

    public function recent()
    {
        return $this->service->recent();
    }
}
