<?php

namespace App\Services\Api\V1;

use App\Models\Business;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BusinessService
{
    public function index (Int $user_id)
    {
        $business = business::where('user_id', $user_id)->paginate(15);
        return $business;
    }

    public function store ($request, $user_id)
    {
        $has_image = false;
        if (isset($request->image)) {
            $image = Str::random(25).'.'.$request->image->getClientOriginalExtension();
            $destinationPath = public_path().'/uploads/images/businessImages/';
            $request->image->move($destinationPath, $image);
            $path = env('APP_URL').'/images/'.$image;
            $has_image = true;
        }

        $business = Business::create([
            'image' => $has_image ? $path : null,
            'name' => $request->name,
            'short_name' => $request->short_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'country' => $request->country,
            'user_id' => $user_id,
        ]);

        return $business;  
    }

    public function show (Int $id)
    {
        $business = business::where('id', $id)->with('menus')->first();
        return $business;
    }
    
    public function find (String $short_name)
    {
        $business = business::where('short_name', $short_name)->with('menus')->first();
        return $business;
    }

    public function update (Object $request, Int $id)
    {
        $business = business::where('id', $id)->first();
        if ($business !== null) {
            $contains_image = false;
            $path = '';

            if (isset($request->image)) {
                $image = Str::random(25).'.'.$request->image->getClientOriginalExtension();
                $destinationPath = public_path().'/uploads/images/businessImages/';
                $request->image->move($destinationPath, $image);
                $path = env('APP_URL').'/images/'.$image;
                $contains_image = true;
            }

            $business->update([
                'name' => isset($request->name)? $request->name : $business->name,
                'short_name' => isset($request->short_name)? $request->short_name : $business->short_name,
                'email' => isset($request->email)? $request->email : $business->email,
                'phone' => isset($request->phone)? $request->phone : $business->phone,
                'address' => isset($request->address)? $request->address : $business->address,
                'is_active' => isset($request->is_active)? $request->is_active : $business->is_active,
                'country' => isset($request->country)? $request->country : $business->country,
                'image' => $contains_image ? $path : $business->image,
            ]);
            return true;
        }
        return false; 
    }

    public function delete (Int $id)
    {
        $business = business::find($id);
        if ($business !== null) {
            $business->forceDelete();
            return true;
        }
        return true;
    }
}