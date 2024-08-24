<?php

namespace App\Http\Resources\V1;

use App\Enum\TalentJobType;
use App\Models\V1\JobApply;
use App\Models\V1\JobView;
use App\Models\V1\TalentJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class BusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $jobs = TalentJob::where('business_id', $this->id)
        ->where('status', 'active')
        ->get();
        $total_open = $jobs->count();

        $total_complete = TalentJob::where('business_id', $this->id)
        ->where('status', 'completed')
        ->count();

        $total_hire = TalentJob::where('business_id', $this->id)
        ->where('status', 'hired')
        ->count();

        $status = false;
        if($this->talentjob()->count() >= 1){
            $status = true;
        }

        $applycount = 0;
        $jobid = $jobs->pluck('id');
        $apply = JobApply::whereIn('job_id', $jobid)->get();
        $applycount = $apply->count();

        $currentDateTime = Carbon::now();
        $sevenDaysAgo = $currentDateTime->subDays(7);

        $new_applicants = $apply->where('created_at', '>=', $sevenDaysAgo)
        ->groupBy('talent_id')
        ->count();

        $jobCounts = TalentJob::select('job_type', DB::raw('count(*) as count'))
        ->where('business_id', $this->id)
        ->groupBy('job_type')
        ->get()
        ->pluck('count', 'job_type');

        $remoteCount = $jobCounts->get('remote', 0);
        $fullTimeCount = $jobCounts->get('full-time', 0);
        $partTimeCount = $jobCounts->get('part-time', 0);
        $internshipCount = $jobCounts->get('internship', 0);
        $contractCount = $jobCounts->get('contract', 0);

        $views = JobView::whereIn('talent_job_id', $jobid)->count();

        $job_post = $this->talentjobtypes()->where('type', TalentJobType::STANDARD)->first();

        return [
            'id' => (string)$this->id,
            'uniqueId' => (string)$this->uuid,
            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'email' => (string)$this->email,
            'business_name' => (string)$this->business_name,
            'country_code' => (string)$this->country_code,
            'phone_number' => (string)$this->phone_number,
            'location' => (string)$this->location,
            'longitude' => (string)$this->longitude,
            'latitude' => (string)$this->latitude,
            'industry' => (array)$this->industry,
            'about_business' => (string)$this->about_business,
            'website' => (string)$this->website,
            'business_service' => (string)$this->business_service,
            'business_email' => (string)$this->business_email,
            'company_logo' => (string)$this->company_logo,
            'company_type' => (string)$this->company_type,
            'size' => (string)$this->size,
            'social_media' => (object) [
                'facebook' => $this->social_media,
                'twitter' => $this->social_media,
                'instagram' => $this->social_media,
                'behance' => $this->social_media,
            ],
            'type' => (string)$this->type,
            'total_opened_jobs' => $total_open,
            'completed_jobs' => $total_complete,
            'remote_jobs' => $remoteCount,
            'fulltime_jobs' => $fullTimeCount,
            'parttime_jobs' => $partTimeCount,
            'internship_jobs' => $internshipCount,
            'contract_jobs' => $contractCount,
            'hired_jobs' => $total_hire,
            'posted_job' => $status,
            'total_number_applicants' => $applycount,
            'new_applicants' => $new_applicants,
            'total_number_job_views' => $views,
            'status' => (string)$this->status,
            'job_standard_post_attempt' => $job_post?->attempt,
        ];
    }
}
