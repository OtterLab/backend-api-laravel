<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /** 
     * display rooms
    */

    public function showAllRooms(Request $request)
    {
        return Room::filtered($request)->with('capacity')->with('type')->get();
    }

    /**
     * create new room
    */

    public function createRoom(Request $request)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'room_type_id' => 'required|integer|min:1',
            'room_capacity_id' => 'required|integer|min:1',
            'room_image' => 'image|mimes:jpeg,jpg,png,svg,gif|max:2048'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        $room = new Room();
        $room->fill($request->all());

        /** Image upload */
        $fileName = time() . '.' . $request->room_image->extension();
        $request->room_image->storeAs('public/uploads/rooms', $fileName);

        if($room->save()) {
            return response()->json([
                'room' => $room,
                'message' => 'Room created successfully'
            ], 201);
        }
        else {
            return response()->json([
                'errors' => 'Unable to create room'
            ], 422);
        }
    }

    /**
     * display specified rooms
    */

    public function getRoom($id)
    {
        $room = Room::FindOrFail($id);
        return response()->json($room, 200);
    }

    /**
     * Update rooms 
    */

    public function updateRoom(Request $request, $id)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'room_type_id' => 'required|integer|min:1',
            'room_capacity_id' => 'required|integer|min:1',
            'room_image' => 'image|mimes:jpeg,jpg,png,svg,gif|max:2048'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        $fileName = '';
        if($request->hasFile('room_image')) {
            $fileName = time() . '.' . $request->room_image->extension();
            $request->room_image->storeAs('public/uploads/rooms', $fileName);
            if($room->room_image) {
                Storage::delete('public/uploads/rooms/' . $room->room_image);
            }
        } else {
            $fileName = $room->room_image;
        }

        if($room->update($request->all())) {
            return response()->json([
                'room' => $room,
                'message' => 'Room updated successfully'
            ], 202);
        }
        else {
            return response()->json([
                'error' => 'Unable to update room'
            ], 400);
        }
    }

    /**
     * Delete rooms 
    */

    public function deleteRoom($id)
    {
        $room = Room::FindOrFail($id);

        /** delete image */
        if($room->room_image) {
            Storage::delete('public/uploads/rooms/' . $room->room_image);
        }

        if($room->delete()) {
            return response()->json([
                'message' => 'Room deleted successfully'
            ], 202);
        }
        else {
            return response()->json([
                'error' => 'Unable to delete room'
            ], 400);
        }
    }
}