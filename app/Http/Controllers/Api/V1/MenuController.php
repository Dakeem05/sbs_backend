<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\MenuCreationRequest;
use App\Services\Api\V1\MenuService;
use App\Traits\Api\V1\ApiResponseTrait;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private MenuService $menu_service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(String $business_uuid)
    {
        $res = $this->menu_service->index($business_uuid);
        if ($res !== null) {
            return $this->successResponse($res);
        }
        return $this->serverErrorResponse('Business not found!!');
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
    public function store(MenuCreationRequest $request)
    {
        $_data = (Object) $request->validated();
    
        $res = $this->menu_service->store($_data, auth()->user()->id);
        if ($res !== null) {
            return $this->successResponse($res, 'Menu created successfully.');
        }
        return $this->serverErrorResponse('An error occurred.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
