<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminExternalJobRequest;
use App\Services\Admin\Jobs\ExternalJobService;
use Illuminate\Http\Request;

class AdminExternalJobController extends Controller
{
    protected $service;

    public function __construct(ExternalJobService $externalJobService)
    {
        $this->service = $externalJobService;
    }

    public function jobCreate(AdminExternalJobRequest $request)
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

    public function editJob(Request $request, $slug)
    {
        return $this->service->editJob($request, $slug);
    }

    public function closeJob($slug)
    {
        return $this->service->closeJob($slug);
    }
}
