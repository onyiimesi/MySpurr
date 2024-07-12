<?php

namespace App\Services\Others;

use App\Http\Resources\Admin\EventResource;
use App\Models\Admin\Event;

class EventService
{
    public function getAll()
    {
        $events = Event::with('eventBrandPartners')
        ->orderBy('created_at', 'desc')
        ->paginate(25);

        $data = EventResource::collection($events);

        return [
            'status' => 'true',
            'message' => 'Job List',
            'data' => $data,
            'pagination' => [
                'current_page' => $events->currentPage(),
                'last_page' => $events->lastPage(),
                'per_page' => $events->perPage(),
                'prev_page_url' => $events->previousPageUrl(),
                'next_page_url' => $events->nextPageUrl()
            ],
        ];
    }

    public function getOne($id)
    {
        $event = Event::with('eventBrandPartners')->findOrFail($id);
        $data = new EventResource($event);

        return [
            'status' => true,
            'message' => "Event Details",
            'data' => $data
        ];
    }

    public function getSlug($slug)
    {
        $event = Event::with('eventBrandPartners')
        ->where('slug', $slug)
        ->firstOrFail();
        $data = new EventResource($event);

        return [
            'status' => true,
            'message' => "Event Details",
            'data' => $data
        ];
    }

    public function related()
    {
        $events = Event::with('eventBrandPartners')
        ->orderBy('created_at', 'desc')
        ->take(4)
        ->get();

        $data = EventResource::collection($events);

        return [
            'status' => 'true',
            'message' => 'Related Event',
            'data' => $data
        ];
    }
}

