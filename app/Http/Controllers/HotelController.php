<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    /** 
     * display all hotels
    */

    public function showAllHotels(Request $request)
    {
        $hotel = Hotel::all();
        return response()->json($hotel, 200);
    }

    /** 
     * create hotels
     * 
     * @param [string] hotel_name
     * @param [string] location
     * @param [string] ratings
    */

    public function createHotel(Request $request)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'hotel_name' => 'required|string',
            'location' => 'required|string',
            'ratings' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        $hotel = Hotel::create([
            'hotel_name' => $request->hotel_name,
            'location' => $request->location,
            'ratings' => $request->ratings
        ]);

        if($hotel->save()) {
            return response()->json([
                'hotel' => $hotel,
                'message' => 'Hotel created successfully'
            ], 201);
        }
        else {
            return response()->json([
                'error' => 'Unable to create hotel'
            ], 422);
        }
    }

    /** 
     * Display specified Hotels
    */

    public function getHotel($id)
    {
        $hotel = Hotel::FindOrFail($id);
        return response()->json($hotel, 200);
    }

    /** 
     * Update hotel
    */

    public function updateHotel(Request $request, $id)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'hotel_name' => 'required|string',
            'location' => 'required|string',
            'ratings' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        if($hotel->update($request->all())) {
            return response()->json([
                'hotel' => $hotel,
                'message' => 'Hotel updated successfully'
            ], 202);
        }
        else {
            return response()->json([
                'error' => 'Unable to update Hotel'
            ], 400);
        }
    }

    /** 
     * delete Hotels
    */

    public function deleteHotel($id)
    {
        $hotel = Hotel::FindOrFail($id);

        if($hotel->delete()) {
            return response()->json([
                'message' => 'Hotel deleted successfully'
            ], 202);
        }
        else {
            return response()->json([
                'message' => 'Unable to delete Hotel'
            ], 400);
        }
    }

}
