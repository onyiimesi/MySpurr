<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\V1\Business;
use App\Models\V1\Talent;
use App\Services\Admin\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
}
