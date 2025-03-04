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

    public function editJob(Request $request, $slug)
    {
        return $this->service->editJob($request, $slug);
    }

    public function closeJob($slug)
    {
        return $this->service->closeJob($slug);
    }

    public function allCharges()
    {
        return $this->service->allCharges();
    }

    public function createCharge(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'percentage' => ['required', 'numeric', 'min:0', 'max:100']
        ]);

        return $this->service->createCharge($request);
    }

    public function chargeDetail($id)
    {
        return $this->service->chargeDetail($id);
    }

    public function editCharge(Request $request, $id)
    {
        $request->validate(['status', 'in:active,in-active']);

        return $this->service->editCharge($request, $id);
    }

    public function deleteCharge($id)
    {
        return $this->service->deleteCharge($id);
    }

}
