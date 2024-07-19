<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SkillsResource;
use App\Models\V1\Skill;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::get();
        $skill = SkillsResource::collection($skills);

        return [
            "status" => 'true',
            "message" => 'Skills List',
            "data" => $skill
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string']
        ]);

        Skill::create([
            'name' => $request->name
        ]);

        return $this->success(null, "Created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
