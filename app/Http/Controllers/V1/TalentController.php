<?php

namespace App\Http\Controllers\V1;

use App\Enum\UserStatus;
use App\Models\V1\Talent;
use App\Models\V1\JobTitle;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TalentResource;
use App\Http\Resources\V1\JobTitleResource;
use App\Http\Resources\V1\TalentListResource;

class TalentController extends Controller
{
    use HttpResponses;

    public function listTalents(Request $request)
    {
        $query = Talent::with(['portfolios.portfolioprojectimage'])
            ->where('status', UserStatus::ACTIVE);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                ->orWhere('last_name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('skill')) {
            $query->where('skill_title', $request->skill);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('experience')) {
            $query->where('experience_level', 'like', '%' . $request->experience . '%');
        }

        if ($request->filled('qualification')) {
            $query->where('highest_education', 'like', '%' . $request->qualification . '%');
        }

        if ($request->filled('salary_min') && $request->filled('salary_max')) {
            $query->whereBetween('rate', [$request->salary_min, $request->salary_max]);
        }

        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        $query->withCount([
            'portfolios',
            'topskills',
            'educations',
            'employments',
            'certificates'
        ])
        ->orderByRaw('
            CASE
                WHEN image IS NOT NULL THEN 1
                ELSE 0
            END DESC,
            portfolios_count DESC,
            topskills_count DESC,
            educations_count DESC,
            employments_count DESC,
            certificates_count DESC
        ');

        $talents = $query->paginate(25);

        $talent = TalentListResource::collection($talents);

        return [
            'status' => 'true',
            'message' => 'Talent List',
            'data' => $talent,
            'pagination' => [
                'current_page' => $talents->currentPage(),
                'last_page' => $talents->lastPage(),
                'per_page' => $talents->perPage(),
                'prev_page_url' => $talents->previousPageUrl(),
                'next_page_url' => $talents->nextPageUrl(),
                'total' => $talents->total()
            ],
        ];
    }

    public function talentbyid(Request $request)
    {
        $talents = Talent::with([
                'topskills',
                'educations',
                'employments',
                'certificates',
                'portfolios',
                'talentwallet',
                'talentbillingaddress',
                'talentidentity',
            ])
            ->where('uuid', $request->uuid)
            ->where('status', UserStatus::ACTIVE)
            ->firstOrFail();

        $data = new TalentResource($talents);

        return $this->success($data, "Talent detail");
    }

    public function jobtitle()
    {
        $title = JobTitle::get();
        $titles = JobTitleResource::collection($title);

        return $this->success($titles, "Job title list");
    }

    public function createJobTitle(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string']
        ]);

        JobTitle::create([
            'name' => $request->name
        ]);

        return $this->success(null, "Created successfully", 201);
    }
}
