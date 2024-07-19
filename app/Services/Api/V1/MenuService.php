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

    public function show (Int $id)
    {
        $menu = menu::where('id', $id)->with('menus')->first();
        return $menu;
    }
    
    public function find (String $short_name)
    {
        $menu = menu::where('short_name', $short_name)->with('menus')->first();
        return $menu;
    }

    public function update (Object $request, Int $id)
    {
        $menu = menu::where('id', $id)->first();
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
                'short_name' => isset($request->short_name)? $request->short_name : $menu->short_name,
                'email' => isset($request->email)? $request->email : $menu->email,
                'phone' => isset($request->phone)? $request->phone : $menu->phone,
                'address' => isset($request->address)? $request->address : $menu->address,
                'is_active' => isset($request->is_active)? $request->is_active : $menu->is_active,
                'country' => isset($request->country)? $request->country : $menu->country,
                'image' => $contains_image ? $path : $menu->image,
            ]);
            return true;
        }
        return false; 
    }

    public function delete (Int $id)
    {
        $menu = menu::find($id);
        if ($menu !== null) {
            $menu->forceDelete();
            return true;
        }
        return true;
    }
}