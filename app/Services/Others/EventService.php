<?php

namespace App\Services\Others;

use App\Actions\SendMailAction;
use App\Http\Resources\Admin\EventResource;
use App\Mail\v1\EventRegisterMail;
use App\Models\Admin\Event;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class EventService
{
    use HttpResponses;

    public function getAll()
    {
        $events = Event::with('eventBrandPartners')
        ->orderBy('event_date', 'asc')
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
        ->take(3)
        ->get();

        $data = EventResource::collection($events);

        return [
            'status' => 'true',
            'message' => 'Related Event',
            'data' => $data
        ];
    }

    public function registerEvent($request)
    {
        $user = Auth::user();
        $event = Event::with('registeredEvents')->find($request->event_id);

        if(!$event){
            return $this->error(null, 404, "Not found");
        }

        $check = $event->registeredEvents()
        ->where('email', $user->email)
        ->exists();

        if($check){
            return $this->error(null, 403, "Sorry you have registered for the event");
        }

        $info = $event->registeredEvents()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'creative_profession' => $request->creative_profession,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'description' => $request->description
        ]);

        try {
            (new SendMailAction($request->email, new EventRegisterMail($event, $info)))->run();
        } catch (\Throwable $th) {
            throw $th;
        }

        return $this->success(null, "Registered successfully");
    }
}

