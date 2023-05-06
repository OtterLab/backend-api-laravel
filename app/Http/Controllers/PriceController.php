<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use Illuminate\Support\Facades\Validator;

class PriceController extends Controller
{
    /** 
     * Display all Prices
    */

    public function showAllPrices()
    {
        $price = Price::all();
        return response()->json($price, 200);
    }

    /** 
     * Filter price
    */

    public function pricesFiltered(Request $request)
    {
        $prices = Price::filtered($request->all())->orderBy('day', 'desc')
            ->orderBy('start_date', 'desc')->first();
            
            return response()->json($prices, 202);
    }

    /** 
     * Create Price
     * 
     * @param [string] name
     * @param [string] room
     * @param [bigInt] room_type_id
     * @param [bigInt] room_capacity_id
     * @param [string] day
     * @param [date] start_date
     * @param [date] end_date
    */

    public function createPrice(Request $request)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'room' => 'integer|min:1',
            'price' => 'required|string',
            'room_type_id' => 'required|integer|min:1',
            'room_capacity_id' => 'required|integer|min:1',
            'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday,all',
            'start_date', 'date',
            'end_date' => 'date'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        $price = new Price();
        $price->fill($request->all());

        if(empty($request->start_date) || empty($request->end_date)) {
            $price->start_date = null;
            $price->end_date = null;
        }

        if($price->save()) {
            return response()->json([
                'price' => $price,
                'message' => 'Price created successfully'
            ], 201);
        }
        else {
            return response()->json([
                'message' => 'Unable to create price'
            ], 422);
        }
    }

    /** 
     * Display specified price
    */

    public function getPrice($id)
    {
        $price = Price::FindOrFail($id);
        return response()->json($price, 200);
    }

    /** 
     * Update price
    */

    public function updatePrice(Request $request, $id)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'room' => 'integer|min:1',
            'price' => 'required|string',
            'room_type_id' => 'required|integer|min:1',
            'room_capacity_id' => 'required|integer|min:1',
            'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday,all',
            'start_date', 'date',
            'end_date' => 'date'
        ]);

        if($validator->fails()) {
            return response()->json([
                'price' => $price,
                'errors' => $validator->messages()
            ], 200);
        }

        //$price->fill($request->all());

        if(empty($request->start_date) || empty($request->end_date)) {
            $price->start_date = null;
            $price->end_date = null;
        }

        if($price->update($request->all())) {
            return response()->json([
                'price' => $price,
                'message' => 'Price created successfully'
            ], 201);
        }
        else {
            return response()->json([
                'message' => 'Unable to create price'
            ], 422);
        }
    }

    /** 
     * Delete Price 
    */

    public function deletePrice($id)
    {
        $price = Price::FindOrFail($id);
        
        if($price->delete()) {
            return response()->json([
                'message' => 'Price deleted successfully'
            ], 202);
        }
        else {
            return response()->json([
                'error' => 'Unable to delete price'
            ], 400);
        }
    }
}