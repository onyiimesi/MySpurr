<?php

namespace App\Services\Admin\Event;

use App\Http\Resources\Admin\EventResource;
use App\Models\Admin\Event;
use App\Services\Upload\UploadService;
use App\Traits\HttpResponses;

class EventService
{
    use HttpResponses;

    public function eventCreate($request)
    {
        try {

            $data = null;
            $featured_graph = null;

            if ($request->hasFile('featured_speaker')){
                $file = $request->file('featured_speaker');
                $folder = 'event/featuredspeaker';

                $data = (new UploadService($folder, $file))->run();
            }

            if ($request->hasFile('featured_graphics')){
                $file = $request->file('featured_graphics');
                $folder = 'event/featuredgraphics';

                $featured_graph = (new UploadService($folder, $file))->run();
            }

            $published = $request->status === "active" ? 1 : 0;
            
            $event = Event::create([
                'title' => $request->title,
                'speaker_bio' => $request->speaker_bio,
                'speaker' => $request->speaker,
                'event_time' => $request->event_time,
                'event_date' => $request->event_date,
                'timezone' => $request->timezone,
                'address' => $request->address,
                'linkedln' => $request->linkedln,
                'content' => $request->content,
                'tags' => $request->tags,
                'featured_speaker' => $data->url ?? $data,
                'file_id' => $data->file_id ?? null,
                'featured_graphics' => $featured_graph->url ?? $featured_graph,
                'featured_graphic_file_id' => $featured_graph->file_id ?? null,
                'publish_date' => $request->publish_date,
                'is_published' => $published,
                'status' => $request->status
            ]);

            if ($request->hasFile('brand_partners')) {
                $files = $request->file('brand_partners');
            
                if (!is_array($files)) {
                    $files = [$files];
                }
            
                foreach ($files as $file) {
                    $folder = 'event/brandpartners';
                    $data = (new UploadService($folder, $file))->run();
            
                    $event->eventBrandPartners()->create([
                        'image' => $data->url ?? $data,
                        'file_id' => $data->file_id ?? null,
                    ]);
                }
            }

            return $this->success(null, "Created successfully");

        } catch (\Exception $e) {
            return $this->error(null, 500, $e->getMessage());
        }
    }

    public function getAll()
    {
        $perPage = request()->query('per_page', 25);
        $events = Event::with('eventBrandPartners')->paginate($perPage);
        $data = EventResource::collection($events);

        return [
            'status' => true,
            'message' => "Event List",
            'value' => [
                'result' => $data,
                'current_page' => $events->currentPage(),
                'page_count' => $events->lastPage(),
                'page_size' => $events->perPage(),
                'total_records' => $events->total()
            ]
        ];
    }

    public function getOne($id)
    {
        $event = Event::findOrFail($id);
        $data = new EventResource($event);

        return [
            'status' => true,
            'message' => "Event Details",
            'value' => $data
        ];
    }

    public function editEvent($request, $id)
    {
        $event = Event::findOrFail($id);

        try {

            $data = null;
            $featured_graph = null;

            if ($request->hasFile('featured_speaker')){
                $file = $request->file('featured_speaker');
                $folder = 'event/featuredspeaker';

                $data = (new UploadService($folder, $file))->run();
            } else {
                $data = [
                    'url' => $event->featured_speaker,
                    'file_id' => $event->file_id
                ];
            }

            if ($request->hasFile('featured_graphics')){
                $file = $request->file('featured_graphics');
                $folder = 'event/featuredgraphics';

                $featured_graph = (new UploadService($folder, $file))->run();

            } else {
                $featured_graph = [
                    'url' => $event->featured_graphics,
                    'file_id' => $event->file_id
                ];
            }

            $published = $request->status === "active" ? 1 : 0;
            
            $event->update([
                'title' => $request->title,
                'speaker_bio' => $request->speaker_bio,
                'speaker' => $request->speaker,
                'event_time' => $request->event_time,
                'event_date' => $request->event_date,
                'timezone' => $request->timezone,
                'address' => $request->address,
                'linkedln' => $request->linkedln,
                'content' => $request->content,
                'tags' => $request->tags,
                'featured_speaker' => $data['url'] ?? $data->url ?? $data,
                'file_id' => $data['file_id'] ?? $data->file_id ?? null,
                'featured_graphics' => $featured_graph['url'] ?? $featured_graph->url ?? $featured_graph,
                'featured_graphic_file_id' => $featured_graph['file_id'] ?? $featured_graph->file_id ?? null,
                'publish_date' => $request->publish_date,
                'is_published' => $published,
                'status' => $request->status
            ]);

            if ($request->hasFile('brand_partners')) {
                $files = $request->file('brand_partners');
            
                if (!is_array($files)) {
                    $files = [$files];
                }
                
                $event->eventBrandPartners()->delete();
                foreach ($files as $file) {
                    $folder = 'event/brandpartners';
                    $data = (new UploadService($folder, $file))->run();
            
                    $event->eventBrandPartners()->create([
                        'image' => $data->url ?? $data,
                        'file_id' => $data->file_id ?? null,
                    ]);
                }
            }

            return $this->success(null, "Updated successfully");

        } catch (\Exception $e) {
            return $this->error(null, 500, $e->getMessage());
        }
    }

    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return $this->success(null, "Event deleted successfully");
    }

    public function count()
    {
        $data = Event::count();

        return [
            'status' => true,
            'message' => "All Events",
            'value' => $data
        ];
    }
}

