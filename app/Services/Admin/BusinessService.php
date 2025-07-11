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
        $searchFilter = request()->query('searchFilter', []);
        $search = request()->query('q');

        if (is_string($searchFilter)) {
            $searchFilter = json_decode($searchFilter, true);
        }

        $query = Business::with(['talentjob'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('business_name', 'like', '%' . $search . '%');
                });
            })
            ->when($searchFilter, function ($query) use ($searchFilter) {
                if (isset($searchFilter['name'])) {
                    $query->where(function ($query) use ($searchFilter) {
                        $query->where('first_name', 'like', '%' . $searchFilter['name'] . '%')
                            ->orWhere('last_name', 'like', '%' . $searchFilter['name'] . '%');
                    });
                }
                if (isset($searchFilter['email'])) {
                    $query->where('email', 'like', '%' . $searchFilter['email'] . '%');
                }
                if (isset($searchFilter['business_name'])) {
                    $query->where('business_name', 'like', '%' . $searchFilter['business_name'] . '%');
                }
            });

        $business = $query->paginate($perPage);
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
        $business = Business::withTrashed()->findOrFail($id);
        $business->forceDelete();

        return $this->success(null, "Deleted successfully");
    }

    public function count()
    {
        $data = Business::count();

        return [
            'status' => true,
            'message' => "All Business",
            'value' => $data
        ];
    }
}





