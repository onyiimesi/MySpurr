<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Services\Admin\Event\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $service;

    public function __construct(EventService $eventService)
    {
        $this->service = $eventService;
    }

    public function eventCreate(EventRequest $request)
    {
        return $this->service->eventCreate($request);
    }

    public function getAll()
    {
        return $this->service->getAll();
    }

    public function getOne($id)
    {
        return $this->service->getOne($id);
    }

    public function editEvent(Request $request, $id)
    {
        return $this->service->editEvent($request, $id);
    }

    public function deleteEvent($id)
    {
        return $this->service->deleteEvent($id);
    }

    public function count()
    {
        return $this->service->count();
    }
    
}