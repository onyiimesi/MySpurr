<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\JobTitleResource;
use App\Http\Resources\V1\SkillsResource;
use App\Models\V1\Business;
use App\Models\V1\CountryTwo;
use App\Models\V1\JobTitle;
use App\Models\V1\Skill;
use App\Models\V1\State;
use App\Models\V1\Talent;
use App\Services\Upload\UploadService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class OthersController extends Controller
{
    use HttpResponses;

    public function forgot(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $talent = Talent::where('email', $request->email)->first();

        if (!$talent) {
            return $this->error('error', 404, 'We can\'t find a talent with that email address');
        }

        $status = Password::broker('talent')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 500);
    }

    public function businessForgot(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $business = Business::where('email', $request->email)->first();

        if (!$business) {
            return $this->error('error', 404, 'We can\'t find a business with that email address');
        }

        $status = Password::broker('business')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 500);
    }

    public function createJobtitle(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:job_titles,name'],
            'min_rate' => ['required'],
            'max_rate' => ['required'],
        ]);

        JobTitle::create([
            'name' => $request->name,
            'min_rate' => $request->min_rate,
            'max_rate' => $request->max_rate,
        ]);

        return $this->success(null, "Created successfully");
    }

    public function allJobTitles()
    {
        $perPage = request()->query('per_page', 25);
        $title = JobTitle::select(['id', 'name', 'min_rate', 'max_rate'])
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);

        $titles = JobTitleResource::collection($title);

        return [
            "status" => 'true',
            "message" => 'Job Title List',
            "value" => [
                'result' => $titles,
                'current_page' => $title->currentPage(),
                'page_count' => $title->lastPage(),
                'page_size' => $title->perPage(),
                'total_records' => $title->total()
            ]
        ];
    }

    public function jobTitle($id)
    {
        $jobTitle = JobTitle::findOrFail($id);
        $data = new JobTitleResource($jobTitle);

        return [
            'status' => true,
            'message' => "Job category Details",
            'value' => $data
        ];
    }

    public function editJobTitle(Request $request, $id)
    {
        $jobTitle = JobTitle::findOrFail($id);

        $jobTitle->update([
            'name' => $request->name,
            'min_rate' => $request->min_rate,
            'max_rate' => $request->max_rate,
        ]);

        return $this->success(null, "Updated successfully");
    }

    public function deleteJobTitle($id)
    {
        JobTitle::findOrFail($id)->delete();

        return $this->success(null, "Deleted successfully");
    }

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')){
            $file = $request->file('file');
            $folder = $request->input('folder', 'default/folder');

            $data = (new UploadService($folder, $file))->run();
        }

        $data = (object)[
            'url' => $data->url ?? $data
        ];

        return $this->success($data, "Successful");
    }

    public function warningMail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'type' => ['required', 'in:talent,business']
        ]);

        switch ($request->type) {
            case 'talent':
                return $this->warningTalentEmail($request);
                break;

            case 'business':
                return $this->warningBusinessEmail($request);
                break;

            default:
                return $this->error(null, 400, 'Type does not exist');
                break;
        }

    }

    public function suspendUser(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'type' => ['required', 'in:talent,business']
        ]);

        switch ($request->type) {
            case 'talent':
                return $this->suspendTalent($request);
                break;

            case 'business':
                return $this->suspendBusiness($request);
                break;

            default:
                return $this->error(null, 400, 'Type does not exist');
                break;
        }
    }

    public function reactivateUser(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'type' => ['required', 'in:talent,business']
        ]);

        switch ($request->type) {
            case 'talent':
                return $this->reactivateTalent($request);
                break;

            case 'business':
                return $this->reactivateBusiness($request);
                break;

            default:
                return $this->error(null, 400, 'Type does not exist');
                break;
        }
    }

    public function getCountries()
    {
        $countries = CountryTwo::select('id', 'name', 'iso2')->get();

        return [
            'status' => true,
            'message' => "Country",
            'value' => $countries
        ];
    }

    public function getStates($id)
    {
        $states = State::where('country_id', $id)
        ->select('id', 'name', 'iso2')
        ->get();

        return [
            'status' => true,
            'message' => "States",
            'value' => $states
        ];
    }

    public function getSkills()
    {
        $skills = Skill::select('id', 'name')
        ->get();

        return [
            'status' => true,
            'message' => "Skills",
            'value' => $skills
        ];
    }

    public function allSkills()
    {
        $perPage = request()->query('per_page', 25);
        $skill = Skill::select(['id', 'name'])
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);

        $skills = SkillsResource::collection($skill);

        return [
            "status" => 'true',
            "message" => 'Skills List',
            "value" => [
                'result' => $skills,
                'current_page' => $skill->currentPage(),
                'page_count' => $skill->lastPage(),
                'page_size' => $skill->perPage(),
                'total_records' => $skill->total()
            ]
        ];
    }

    public function createSkill(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:skills,name'],
        ]);

        Skill::create([
            'name' => $request->name
        ]);

        return $this->success(null, "Created successfully");
    }

    public function skillDetail($id)
    {
        $skill = Skill::findOrFail($id);
        $data = new SkillsResource($skill);

        return [
            'status' => true,
            'message' => "Skill Details",
            'value' => $data
        ];
    }

    public function editSkill(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);

        $skill->update([
            'name' => $request->name
        ]);

        return $this->success(null, "Updated successfully");
    }

    public function deleteSkill($id)
    {
        Skill::findOrFail($id)->delete();

        return $this->success(null, "Deleted successfully");
    }

}
