<?php

namespace App\Services\Api\V1;

use App\Models\Business;
use App\Models\menu;
use Illuminate\Support\Str;

class MenuService
{
    public function index (String $business_uuid)
    {
        $business = Business::findByUuid($business_uuid);
        if ($business !== null) {
            $menu = menu::where('business_id', $business->id)->paginate(15);
            return $menu;
        }
        return null;
    }

    public function store ($request, $user_id)
    {
        $has_image = false;
        if (isset($request->image)) {
            $image = Str::random(25).'.'.$request->image->getClientOriginalExtension();
            $destinationPath = public_path().'/uploads/images/menuImages/';
            $request->image->move($destinationPath, $image);
            $path = env('APP_URL').'/images/'.$image;
            $has_image = true;
        }

        $business = Business::findByUuid($request->business_uuid);

        $menu = menu::create([
            'image' => $has_image ? $path : null,
            'name' => $request->name,
            'description' => $request->description,
            'tag' => $request->tag,
            'price' => $request->price,
            'code' => strtoupper(Str::random(6)),
            'business_id' => $business->id,
        ]);

        return $menu;  
    }

    public function show (String $uuid)
    {
        $menu = menu::where('uuid', $uuid)->first();
        return $menu;
    }
    
    public function find (String $short_name)
    {
        $menu = menu::where('short_name', $short_name)->with('menus')->first();
        return $menu;
    }

    public function update (Object $request, String $uuid)
    {
        $menu = menu::where('uuid', $uuid)->first();
        if ($menu !== null) {
            $contains_image = false;
            $path = '';

            if (isset($request->image)) {
                $image = Str::random(25).'.'.$request->image->getClientOriginalExtension();
                $destinationPath = public_path().'/uploads/images/menuImages/';
                $request->image->move($destinationPath, $image);
                $path = env('APP_URL').'/images/'.$image;
                $contains_image = true;
            }

            $menu->update([
                'name' => isset($request->name)? $request->name : $menu->name,
                'is_available' => isset($request->is_available)? $request->is_available : $menu->is_available,
                'description' => isset($request->description)? $request->description : $menu->description,
                'tag' => isset($request->tag)? $request->tag : $menu->tag,
                'price' => isset($request->price)? $request->price : $menu->price,
                'image' => $contains_image ? $path : $menu->image,
            ]);
            return true;
        }
        return false; 
    }

    public function delete (String $uuid)
    {
        $menu = menu::findByUuid($uuid);
        if ($menu !== null) {
            $menu->forceDelete();
            return true;
        }
        return true;
    }
}