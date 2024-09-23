<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\JobTitleResource;
use App\Models\V1\Business;
use App\Models\V1\JobTitle;
use App\Models\V1\Talent;
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

}
