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
}
