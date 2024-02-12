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
        $answers = QuestionAnswer::whereIn('question_id', $quest)->get();
        
        return [
            'id' => $this->id,
            'rate' => $this->rate,
            'available_start' => $this->available_start,
            'resume' => $this->resume,
            'other_file' => $this->other_file,
            'type' => $this->type,
            'status' => $this->status,
            'date' => Carbon::parse($this->created_at)->format('j M Y'),
            'top_skills' => $this->talent->topskills->map(function($skill) {
                return [
                    'name' => $skill->name
                ];
            })->toArray(),
            'education' => $this->talent->educations->map(function($edu) {
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
            'employment' => $this->talent->employments->map(function($emp) {
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
            'certificate' => $this->talent->certificates->map(function($cert) {
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
            })->toArray()
        ];
    }
}
