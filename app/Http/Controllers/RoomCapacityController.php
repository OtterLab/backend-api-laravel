<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomCapacity;
use Illuminate\Support\Facades\Validator;

class RoomCapacityController extends Controller
{
    /** 
     * Display all room capacity
    */

    public function showAllRoomCapacities() {

        $RoomCapacity = RoomCapacity::all();
        return response()->json($RoomCapacity, 200);
    }

    /** 
     * Create room capacity 
     * 
     * @param [string] name
    */

    public function createRoomCapacity(Request $request)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        $RoomCapacity = RoomCapacity::create([
            'name' => $request->name,
        ]);

        if($RoomCapacity->save()) {
            return response()->json([
                'room_capacity' => $RoomCapacity,
                'message' => 'room capacity created'
            ], 201);
        }
        else {
            response()->json([
                'error' => 'Unable to create room capacity'
            ], 422);
        }
    }

    /** 
     * display specified room capacity 
    */

    public function getRoomCapacity($id)
    {
        $RoomCapacity = RoomCapacity::FindOrFail($id);
        return response()->json($RoomCapacity, 200);
    }

    /** 
     * update Room Capacity
    */

    public function updateRoomCapacity(Request $request, $id)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        $RoomCapacity = RoomCapacity::FindOrFail($id);
        $RoomCapacity->name = $request->get('name');

        if($RoomCapacity->update($request->all())) {
            return response()->json([
                'room_capacity' => $RoomCapacity,
                'message' => 'Room Capacity updated successfully'
            ], 202);
        }
        else {
            return response()->json([
                'message' => 'Unable to update Room Capacity'
            ], 400);
        }
    }

    /** 
     * delete Room Capacity
    */

    public function deleteRoomCapacity($id)
    {
        $RoomCapacity = RoomCapacity::FindOrFail($id);

        if($RoomCapacity->delete()) {
            return response()->json([
                'message' => 'Room Capacity deleted successfully'
            ], 202);
        }
        else {
            return response()->json([
                'message' => 'Unable to delete Room Capacity'
            ], 400);
        }
    }
}