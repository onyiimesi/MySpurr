<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ApplicantsResource;
use App\Http\Resources\V1\ApplicationResource;
use App\Http\Resources\V1\JobResource;
use App\Models\V1\Business;
use App\Models\V1\JobApply;
use App\Models\V1\JobView;
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

    public function jobdetail(Request $request, $slug)
    {
        $user = Auth::user();
        $userId = $user->id;

        $job = TalentJob::where('business_id', $user->id)
        ->where('slug', $slug)
        ->where('status', 'active')
        ->first();

        if(!$job){
            return $this->error(null, 400, "Error slug required");
        }

        if (!$userId) {
            $sessionId = $request->session()->getId();
        }

        $existingView = JobView::where('talent_job_id', $job->id)
        ->where(function ($query) use ($userId, $sessionId) {
            $query->where('talent_id', $userId)->orWhere('session_id', $sessionId);
        })
        ->exists();

        if ($existingView) {
            $data = new JobResource($job);
            return $this->success($data, "Details", 200);
        }

        $job->views()->create([
            'session_id' => $sessionId,
            'talent_id' => $userId
        ]);

        $data = new JobResource($job);
        return $this->success($data, "Details", 200);
    }

    public function listjobdetail(Request $request, $slug)
    {
        $job = TalentJob::with('business')->where('slug', $slug)
        ->where('status', 'active')
        ->first();

        $userId = Auth::id();

        if(!$job){
            return $this->error(null, 400, "Error slug required");
        }

        $sessionId = null;
        if (!$userId) {
            $sessionId = $request->session()->getId();
        }

        $existingView = JobView::where('talent_job_id', $job->id)
        ->where(function ($query) use ($userId, $sessionId) {
            $query->where('talent_id', $userId)->orWhere('session_id', $sessionId);
        })
        ->exists();

        if ($existingView) {
            $data = new JobResource($job);
            return $this->success($data, "Details", 200);
        }

        $job->views()->create([
            'session_id' => $sessionId,
            'talent_id' => $userId
        ]);

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
        $user = Auth::user();
        $business = Business::findOrFail($user->id);

        $job = TalentJob::where('id', $id)
        ->where('business_id', $business->id)
        ->with('jobapply')
        ->first();

        if(!$job){
            return $this->error(null, 400, "Not found");
        }

        $applicants = new ApplicantsResource($job);

        return $this->success($applicants, "Applicants", 200);
    }

    public function application($talentId, $jobId)
    {
        $job = JobApply::where('talent_id', $talentId)
        ->where('job_id', $jobId)
        ->first();

        if(!$job){
            return $this->error(null, 400, "Not found");
        }

        $application = new ApplicationResource($job);

        return $this->success($application, "Application", 200);
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
