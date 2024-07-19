<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\BusinessCreationRequest;
use App\Http\Requests\Api\V1\BusinessUpdateRequest;
use App\Models\Business;
use App\Services\Api\V1\BusinessService;
use App\Traits\Api\V1\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BusinessController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private BusinessService $business_service)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = $this->business_service->index(auth()->user()->id);
        return $this->successResponse($res);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BusinessCreationRequest $request)
    {
        $_data = (Object) $request->validated();
    
        $res = $this->business_service->store($_data, auth()->user()->id);
        if ($res !== null) {
            return $this->successResponse($res, 'Business created successfully.');
        }
        return $this->serverErrorResponse('An error occurred.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $res = $this->business_service->show($id);
        if ($res !== null) {
            return $this->successResponse($res);
        }
        return $this->notFoundResponse('Business not found!!');
    }

    public function find(string $short_name)
    {
        $res = $this->business_service->find($short_name);
        if ($res !== null) {
            return $this->successResponse($res);
        }
        return $this->notFoundResponse('Business not found!!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BusinessUpdateRequest $request, string $id)
    {
        $business = Business::find($id);
        if (!$business) {
            return $this->notFoundResponse('Business not found');
        }
        if (! Gate::allows('update-business', [$business, auth()->user()])) {
            return $this->unauthorizedResponse('Unauthorized Action');
        }
        $_data = (Object) $request->validated();

        $res = $this->business_service->update($_data, $id);
        if ($res) {
            return $this->successResponse($res, 'Business updated successfully.');
        }
        return $this->serverErrorResponse('An error occurred.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $business = business::find($id);
        if (!$business) {
            return $this->notFoundResponse('Business not found');
        }
        if (! Gate::allows('update-business', [$business, auth()->user()])) {
            return $this->unauthorizedResponse('Unauthorized Action');
        }
        $res = $this->business_service->delete($id);
        if ($res) {
            return $this->successResponse($res, 'Business deleted successfully.');
        }
        return $this->serverErrorResponse('An error occurred.');
    }
}
