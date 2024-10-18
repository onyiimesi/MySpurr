<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminJobRequest;
use App\Services\Admin\Jobs\JobService;
use Illuminate\Http\Request;

class AdminJobsController extends Controller
{
    protected $service;

    public function __construct(JobService $talentService)
    {
        $this->service = $talentService;
    }

    public function jobCreate(AdminJobRequest $request)
    {
        return $this->service->jobCreate($request);
    }

    public function index()
    {
        return $this->service->index();
    }

    public function getOne($slug)
    {
        return $this->service->getOne($slug);
    }

    public function count()
    {
        return $this->service->count();
    }
}
