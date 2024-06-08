<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\TalentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminTalentsController extends Controller
{
    protected $service;

    public function __construct(TalentService $talentService)
    {
        $this->service = $talentService;
    }

    public function index()
    {
        return $this->service->index();
    }

    public function singleTalent($id)
    {
        return $this->service->singleTalent($id);
    }
}
