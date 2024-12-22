<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    protected $service;

    public function __construct(AdminService $adminService)
    {
        $this->service = $adminService;
    }

    public function overview(): JsonResponse
    {
        return $this->service->overview();
    }

    public function latestJobs()
    {
        return $this->service->latestJobs();
    }

    public function visitors()
    {
        return $this->service->visitors();
    }
}
