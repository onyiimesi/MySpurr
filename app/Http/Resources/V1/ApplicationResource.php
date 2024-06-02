<?php

namespace App\Http\Resources\V1;

use App\Models\V1\Question;
use App\Models\V1\QuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $questions = Question::where('talent_job_id', $this->job_id)
        ->get();

        $quest = $questions->pluck('id');
        $answers = QuestionAnswer::whereIn('question_id', $quest)
        ->where('job_id', $this->job_id)
        ->where('talent_id', optional($this->talent)->id)
        ->get();

        $rating = optional($this->talent)->ratingsReceived->first();

        return [
            'id' => $this->id,
            'talent_id' => optional($this->talent)->id,
            'uniqueId' => optional($this->talent)->uuid,
            'first_name' => optional($this->talent)->first_name,
            'last_name' => optional($this->talent)->last_name,
            'email' => optional($this->talent)->email,
            'skill_title' => optional($this->talent)->skill_title,
            'overview' => optional($this->talent)->overview,
            'ciso' => optional($this->talent)->ciso,
            'siso' => optional($this->talent)->siso,
            'location' => optional($this->talent)->location,
            'longitude' => optional($this->talent)->longitude,
            'latitude' => optional($this->talent)->latitude,
            'employment_type' => optional($this->talent)->employment_type,
            'highest_education' => optional($this->talent)->highest_education,
            'rate' => optional($this->talent)->rate,
            'available_start' => optional($this->talent)->available_start,
            'resume' => $this->resume,
            'other_file' => $this->other_file,
            'type' => $this->type,
            'status' => $this->status,
            'date' => Carbon::parse($this->created_at)->format('j M Y'),
            'top_skills' => optional($this->talent)->topskills->map(function($skill) {
                return [
                    'name' => $skill->name
                ];
            })->toArray(),
            'education' => optional($this->talent)->educations->map(function($edu) {
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
            'employment' => optional($this->talent)->employments->map(function($emp) {
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
            'certificate' => optional($this->talent)->certificates->map(function($cert) {
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
            'questions' => $questions->map(function($quest) {
                return [
                    'id' => $quest->id,
                    'question' => $quest->question
                ];
            })->toArray(),
            'answers' => $answers->map(function ($answer) {
                return [
                    'id' => $answer->id,
                    'question_id' => $answer->question_id,
                    'answer' => $answer->answer
                ];
            })->toArray(),
            'rating' => $rating ? (float)$rating->rating : null
        ];
    }
}
