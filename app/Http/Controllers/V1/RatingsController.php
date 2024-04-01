<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\Rating;
use App\Models\V1\Talent;
use App\Models\V1\TalentJob;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingsController extends Controller
{
    use HttpResponses;

    public function addRating(Request $request)
    {
        $user = Auth::id();

        $request->validate([
            'job_id' => 'required',
            'talent_id' => 'required',
            'rating' => 'required|numeric|between:1.0,5.0',
        ]);

        try {
            $job = TalentJob::find($request->job_id);
            if(!$job){
                return $this->error(null, 400, "Job not found!");
            }

            $talent = Talent::find($request->talent_id);
            if(!$talent){
                return $this->error(null, 400, "User not found!");
            }
        
            $rating = Rating::firstOrNew(['talent_id' => $request->talent_id]);
        
            $rating->talent_job_id = $request->job_id;
            $rating->rated_by = $user;
            $rating->rating = $request->rating;
            $rating->save();
        
            return $this->success(null, 'Rating submitted successfully.', 200);
        } catch (\Exception $e) {
            return $this->error(null, 400, $e->getMessage());
        }
    }

    public function getRating($jobId, $talentId)
    {
        $rating = Rating::where('talent_job_id', $jobId)
        ->where('talent_id', $talentId)
        ->first();

        if(!$rating){
            return $this->error(null, 400, "Rating not found!");
        }

        return $this->success([
            [
                "rated_by" => $rating->business->last_name . ' '. $rating->business->first_name,
                "rating" => $rating->rating
            ]
        ], 'Rating', 200);
    }
}
