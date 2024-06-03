<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddUserRequest;
use App\Http\Requests\Admin\AdminConnectRequest;
use App\Services\Admin\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function addUser(AddUserRequest $request): JsonResponse
    {
        return $this->service->addUser($request);
    }

    public function connect(AdminConnectRequest $request): JsonResponse
    {
        return $this->service->authLogin($request);
    }
}
