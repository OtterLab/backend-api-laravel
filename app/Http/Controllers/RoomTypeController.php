<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use Illuminate\Support\Facades\Validator;

class RoomTypeController extends Controller
{
    /** 
     * Display all room types
    */

    public function showAllRoomTypes() {

        $RoomType = RoomType::all();
        return response()->json($RoomType, 200);
    }

    /** 
     * Create room type
     * 
     * @param [string] name
    */

    public function createRoomType(Request $request)
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

        $RoomType = RoomType::create([
            'name' => $request->name,
        ]);

        if($RoomType->save()) {
            return response()->json([
                'room_type' => $RoomType,
                'message' => 'room type successfully created'
            ], 201);
        }
        else {
            return response()->json([
                'error' => 'Unable to create room type'
            ], 422);
        }
    }

    /** 
     * display specified room type
    */

    public function getRoomType($id)
    {
        $RoomType = RoomType::FindOrFail($id);
        return response()->json($RoomType, 200);
    }

    /** 
     * update Room Type
    */

    public function updateRoomType(Request $request, $id)
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

        $RoomType = RoomType::FindOrFail($id);
        $RoomType->name = $request->get('name');

        if($RoomType->update($request->all())) {
            return response()->json([
                'room_type' => $RoomType,
                'message' => 'Room Type updated successfully'
            ], 202);
        }
        else {
            return response()->json([
                'message' => 'Unable to update Room Type'
            ], 400);
        }
    }

    /** 
     * delete Room Type
    */

    public function deleteRoomType($id)
    {
        $RoomType = RoomType::FindOrFail($id);

        if($RoomType->delete()) {
            return response()->json([
                'message' => 'Room Type deleted successfully'
            ], 202);
        }
        else {
            return response()->json([
                'message' => 'Unable to delete Room Type'
            ], 400);
        }
    }
}