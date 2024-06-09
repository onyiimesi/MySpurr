<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\BusinessService;
use Illuminate\Http\Request;

class AdminBusinessController extends Controller
{
    protected $service;

    public function __construct(BusinessService $businessService)
    {
        $this->service = $businessService;
    }

    public function index()
    {
        return $this->service->index();
    }

    public function singleBusiness($id)
    {
        return $this->service->singleBusiness($id);
    }

    public function editBusiness(Request $request, $id)
    {
        return $this->service->editBusiness($request, $id);
    }

    public function deleteBusiness($id)
    {
        return $this->service->deleteBusiness($id);
    }
}
