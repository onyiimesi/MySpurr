<?php

namespace App\Services\Admin;

use App\Http\Resources\Admin\BusinessResource;
use App\Models\V1\Business;
use App\Traits\HttpResponses;

class BusinessService
{
    use HttpResponses;

    public function index()
    {
        $perPage = request()->query('per_page', 25);
        $business = Business::with(['talentjob'])->paginate($perPage);
        $business = BusinessResource::collection($business);

        return [
            'status' => true,
            'message' => "All Business",
            'value' => [
                'result' => $business,
                'current_page' => $business->currentPage(),
                'page_count' => $business->lastPage(),
                'page_size' => $business->perPage(),
                'total_records' => $business->total()
            ]
        ];
    }

    public function singleBusiness($id)
    {
        $business = Business::findOrFail($id);
        $data = new BusinessResource($business);

        return [
            'status' => true,
            'message' => "Business Details",
            'value' => $data
        ];
    }

    public function editBusiness($request, $id)
    {
        $talent = Business::findOrFail($id);

        $talent->update([
            'business_name' => $request->business_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'business_email' => $request->business_email,
            'company_type' => $request->company_type,
            'status' => $request->status
        ]);

        return $this->success(null, "Updated successfully");
    }

    public function deleteBusiness($id)
    {
        $talent = Business::findOrFail($id);
        $talent->delete();

        return $this->success(null, "Deleted successfully");
    }
}





