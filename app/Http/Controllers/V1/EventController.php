<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\Others\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $service;

    public function __construct(EventService $eventService)
    {
        $this->service = $eventService;
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

    public function related()
    {
        return $this->service->related();
    }
}
