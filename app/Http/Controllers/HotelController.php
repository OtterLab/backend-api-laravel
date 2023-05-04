<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    /**
     * display all hotels, if more than 1 hotel
    */

    public function showAllHotels(Request $request)
    {
    $hotel = Hotel::all();
    return response()->json($hotel, 200);
    }

    /**
     * Create Hotel
     * 
     * @param [string] hotel_name
     * @param [string] address
     * @param [string] city
     * @param [string] state
     * @param [string] country
     * @param [string] post_code
     * @param [string] phone
     * @param [string] hotel_image
    */

    public function createHotel(Request $request)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'hotel_name' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'post_code' => 'required|string',
            'phone' => 'required|string|numeric',
            'hotel_image' => 'image|mimes:jpeg,jpg,png,svg,gif|max:2048'
        ]);
    
        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        $fileName = time() . '.' . $request->hotel_image->extension();
        $request->hotel_image->storeAs('public/uploads/hotels', $fileName);

        $hotel = Hotel::create([
            'hotel_name' => $request->hotel_name,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'post_code' => $request->post_code,
            'phone' => $request->phone,
            'hotel_image' => $fileName
        ]);

        if($hotel->save()) {
            return response()->json([
                'hotel' => $hotel,
                'message' => 'Hotel successfully created'
            ], 201);
        }
        else {
            return response()->json([
                'error' => 'Unable to create hotel'
            ], 422);
        }
    }

    /**
     * Display the specified hotel 
    */

    public function getHotel($id)
    {
        $hotel = Hotel::FindOrFail($id);
        return response()->json($hotel, 200);
    }

    /** 
     * Update Hotel
    */

    public function updateHotel(Request $request, $id)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'hotel_name' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'post_code' => 'required|string',
            'phone' => 'required|string|numeric',
            'hotel_image' => 'image|mimes:jpeg,jpg,png,svg,gif|max:2048'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        $fileName = '';
        if($request->hasFile('hotel_image')) {
            $fileName = time() . '.' . $request->hotel_image->extension();
            $request->hotel_image->storeAs('public/uploads/hotels', $fileName);
            if($hotel->hotel_image) {
                Storage::delete('public/uploads/hotels/' . $hotel->hotel_image);
            }
        } else {
            $fileName = $hotel->hotel_image;
        }

        $hotel = Hotel::FindOrFail($id);
        $hotel->fill($request->all());

        if($hotel->update($request->all())) {
            return response()->json([
                'hotel' => $hotel,
                'message' => 'Hotel update successfully'
            ], 202);
        }
        else {
            return response()->json([
                'error' => 'Unable to update hotel'
            ], 400);
        }
    }

    /** 
     * Delete Hotel
    */
      
    public function deleteHotel($id)
    {
        $hotel = Hotel::FindOrFail($id);

        /** delete image */
        if($hotel->hotel_image) {
            Storage::delete('public/uploads/hotels/' . $hotel->hotel_image);
        }
        
        if($hotel->delete()) {
            return response()->json([
                'message' => 'Hotel deleted successfully'
            ], 202);
        }
        else {
            return response()->json([
                'error' => 'Unable to delete hotel'
            ], 400);
        }
    }
}