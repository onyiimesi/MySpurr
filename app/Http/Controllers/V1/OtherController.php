<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\JobResource;
use App\Models\V1\JobApply;
use App\Models\V1\OpenTicket;
use App\Models\V1\Talent;
use App\Models\V1\TalentJob;
use App\Services\CountryState\CountryService;
use App\Services\CountryState\StateDetailsService;
use App\Services\CountryState\StateService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OtherController extends Controller
{
    use HttpResponses;

    public function country()
    {
        $country = (new CountryService())->run();

        return $this->success($country, "", 200);
    }

    public function states($ciso)
    {
        $states = (new StateService($ciso))->run();

        return $this->success($states, "", 200);
    }

    public function ticket(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'email:rfc,dns', 'string'],
            'subject' => ['required', 'string'],
            'department' => ['required', 'string'],
            'priority' => ['required', 'string'],
            'zip' => ['required', 'string'],
            'message' => ['required', 'string']
        ]);

        $user = $this->getUser();
        $talent = Talent::where('id', $user->id)->first();

        if($request->attachment){
            $file = $request->attachment;
            $folderName = env('BASE_URL_OPEN_TICKET');
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);
            $sig = str_replace(' ', '+', $sig);
            $file_name = time().'.'.$extension;

            $path = public_path().'/openticket/'.$file_name;
            $success = file_put_contents($path, base64_decode($sig));

            if ($success === false) {
                throw new \Exception("Failed to write file to disk.");
            }

            $path = $folderName.'/'.$file_name;

        } else {
            $path = "";
        }

        $talent->openticket()->create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'department' => $request->department,
            'priority' => $request->priority,
            'zip' => $request->zip,
            'message' => $request->message,
            'attachment' => $path,
            'status' => 'open'
        ]);

        return $this->success(null, "Ticket has been opened", 200);
    }

    public function allticket()
    {
        $ticket = OpenTicket::get();
        $data = $ticket->makeHidden('updated_at');
        return $this->success($data, "All tickets", 200);
    }

    public function ticketId($id)
    {
        $talent = OpenTicket::where('id', $id)->first();
        $data = $talent->makeHidden('updated_at');
        return $this->success($data, "Ticket", 200);
    }

    public function ticketTalentId($id)
    {
        $talent = OpenTicket::where('talent_id', $id)->first();
        $data = $talent->makeHidden('updated_at');
        return $this->success($data, "Ticket", 200);
    }

    public function closeticket($id)
    {
        $talent = OpenTicket::where('id', $id)->first();

        $talent->update([
            'status' => 'closed'
        ]);

        return $this->success(null, "Ticket closed", 200);
    }

    public function jobdetail($slug)
    {
        $user = Auth::user();

        $job = TalentJob::where('business_id', $user->id)
        ->where('slug', $slug)
        ->where('status', 'active')
        ->first();

        if(!$job){
            return $this->error(null, 400, "Error slug required");
        }

        $data = new JobResource($job);

        return $this->success($data, "Details", 200);
    }

    public function deletejob($id)
    {
        $user = Auth::user();

        $jobs = TalentJob::where('business_id', $user->id)
        ->where('id', $id)
        ->first();

        $jobs->delete();
    }

    public function closejob($id)
    {
        $job = TalentJob::where('id', $id)
        ->first();

        $job->update([
            'status' => 'expired'
        ]);

        return $this->success(null, "Job closed", 200);
    }

    public function applicants($id)
    {
        $job = TalentJob::where('id', $id)
        ->with('jobapply')
        ->first();

        if(!$job){
            return $this->error(null, 404, "Not found");
        }

        return $this->success(
            [
                'id' => $job->id,
                'job_title' => $job->job_title,
                'slug' => $job->slug,
                'applicants' => $job->jobapply->map(function ($applicant) {
                    return [
                        'id' => $applicant->id,
                        'talent_id' => $applicant->talent_id,
                        'first_name' => $applicant->talent->first_name,
                        'last_name' => $applicant->talent->last_name,
                        'email' => $applicant->talent->email,
                        'phone_number' => $applicant->talent->phone_number,
                        'image' => $applicant->talent->image,
                        'top_skills' => $applicant->talent->topskills->map(function($skill) {
                            return [
                                'name' => $skill->name
                            ];
                        })->toArray(),
                        'education' => $applicant->talent->educations->map(function($edu) {
                            return [
                                'id' => $edu->id,
                                'school_name' => $edu->school_name,
                                'degree' => $edu->degree,
                                'field_of_study' => $edu->field_of_study,
                                'start_date' => Carbon::parse($edu->start_date)->format('j M Y'),
                                'end_date' => Carbon::parse($edu->end_date)->format('j M Y'),
                                'description' => $edu->description
                            ];
                        })->toArray(),
                        'employment' => $applicant->talent->employments->map(function($emp) {
                            return [
                                'id' => $emp->id,
                                'company_name' => $emp->company_name,
                                'title' => $emp->title,
                                'employment_type' => $emp->employment_type,
                                'start_date' => Carbon::parse($emp->start_date)->format('j M Y'),
                                'end_date' => Carbon::parse($emp->end_date)->format('j M Y'),
                                'description' => $emp->description
                            ];
                        })->toArray(),
                        'certificate' => $applicant->talent->certificates->map(function($cert) {
                            return [
                                'id' => $cert->id,
                                'title' => $cert->title,
                                'institute' => $cert->institute,
                                'certificate_date' => Carbon::parse($cert->certificate_date)->format('j M Y'),
                                'certificate_year' => $cert->certificate_year,
                                'certificate_link' => $cert->certificate_link,
                                'curently_working_here' => $cert->curently_working_here
                            ];
                        })->toArray(),
                        'portfolio' => $applicant->talent->portfolios->map(function($port) {
                            return [
                                'id' => $port->id,
                                'title' => $port->title,
                                'client_name' => $port->client_name,
                                'job_type' => $port->job_type,
                                'location' => $port->location,
                                'max_rate' => $port->max_rate,
                                'min_rate' => $port->min_rate,
                                'tags' => json_decode($port->tags),
                                'cover_image' => $port->cover_image,
                                'body' =>  $port->body
                            ];
                        })->toArray()
                    ];
                })->toArray()
            ],
            "Applicants",
            200
        );
    }

    public function application($id)
    {
        $job = JobApply::where('talent_id', $id)
        ->first();

        if(!$job){
            return $this->error(null, 404, "Not found");
        }

        return $this->success(
            [
                'id' => $job->id,
                'rate' => $job->rate,
                'available_start' => $job->available_start,
                'resume' => $job->resume,
                'other_file' => $job->other_file,
                'type' => $job->type,
                'status' => $job->status,
                'date' => Carbon::parse($job->created_at)->format('j M Y')
            ],
            "Application",
            200
        );
    }

    public function jobpicks()
    {
        $user = Auth::user();
        $talent = Talent::where('id', $user->id)->first();
        $query = TalentJob::query();
        $query->where('job_title', 'LIKE', '%' .$talent->skill_title. '%');
        $jobs = $query->get();
        $resource = JobResource::collection($jobs);

        return $this->success($resource, "Job picks", 200);
    }
}
