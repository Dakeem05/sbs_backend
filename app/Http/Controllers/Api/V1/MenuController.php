<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\MenuCreationRequest;
use App\Http\Requests\Api\V1\MenuUpdateRequest;
use App\Models\Business;
use App\Models\Menu;
use App\Services\Api\V1\MenuService;
use App\Traits\Api\V1\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
        return $this->notFoundResponse('Business not found!!');
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
    public function show(string $uuid)
    {
        $res = $this->menu_service->show($uuid);
        if ($res !== null) {
            return $this->successResponse($res);
        }
        return $this->serverErrorResponse('Menu not found!!');
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
    public function update(MenuUpdateRequest $request, string $uuid)
    {
        $menu = Menu::findByUuid($uuid);
        if (!$menu) {
            return $this->notFoundResponse('Menu not found!!');
        }
        $business = Business::where('id', $menu->business_id)->first();
        if (! Gate::allows('update-business', [$business, auth()->user()])) {
            return $this->unauthorizedResponse('Unauthorized Action');
        }
        $_data = (Object) $request->validated();

        $res = $this->menu_service->update($_data, $uuid);
        if ($res) {
            return $this->successResponse($res, 'Menu updated successfully.');
        }
        return $this->serverErrorResponse('An error occurred.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $menu = Menu::findByUuid($uuid);
        if (!$menu) {
            return $this->notFoundResponse('Menu not found!!');
        }
        $business = Business::where('id', $menu->business_id)->first();
        if (! Gate::allows('update-business', [$business, auth()->user()])) {
            return $this->unauthorizedResponse('Unauthorized Action');
        }
        $res = $this->menu_service->delete($uuid);
        if ($res) {
            return $this->successResponse($res, 'Menu deleted successfully.');
        }
        return $this->serverErrorResponse('An error occurred.');
    }
}
