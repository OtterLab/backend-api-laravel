<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Booking;
use App\Models\User;
use App\Models\Customer;

class BookingController extends Controller
{
    /** 
     * display all bookings
    */

    public function showAllBookings(Request $request)
    {
        $booking = Booking::all();
        return response()->json($booking, 200);
    }

    /** 
     * create bookings
     * 
     * @param [bigInt] room_id
     * @param [date] start_date
     * @param [date] end_date
     * @param [bigInt] customer_id
    */

    public function createBooking(Request $request)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'customer_id' => 'required|integer|min:1'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        if($request->customer['id'] == 0) {
            $user = User::create([
                'fullname' => 'new User',
                'email' => $request->customer['email'],
                'password' => bcrypt('password')
            ]);
        }
        else {
            $user = User::find($request->customer['id']);
        }

        if(!empty($request->customer['customer_id'])) {
            $customer = Customer::find($request->customer['customer_id']);
            $customer->fill($request->customer);
            $customer->save();
        }
        else {
            $customer = new Customer();
            $data = $request->customer;
            unset($data['id']);
            $customer->fill($request->customer);
            $customer->user_id = $user->id;
            $customer->save();
            $user->customer_id = $customer->id;
            $user->save();
        }
        
        if($booking->save()) {
            $booking = Booking::create([
                'room_id' => $request->room['id'],
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'customer_id' => $customer->id 
            ]);

            return response()->json([
                'bookings' => $booking,
                'message' => 'Booking created successfully'
            ], 201);
        }
        else {
            return response()->json([
                'error' => 'Unable to create booking'
            ], 422);
        }
    }

    /** 
     * Display specified Bookings
    */

    public function getBooking($id)
    {
        $booking = Booking::FindOrFail($id);
        return response()->json($booking, 200);
    }

    /** 
     * Update Booking
    */

    public function updateBooking(Request $request, $id)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'customer_id' => 'required|integer|min:1'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        $booking->fill($request->all());

        if($booking->update($request->all())) {
            return response()->json([
                'bookings' => $booking,
                'message' => 'Booking updated successfully'
            ], 202);
        }
        else {
            return response()->json([
                'error' => 'Unable to update Booking'
            ], 400);
        }
    }

    /** 
     * delete Bookings
    */

    public function deleteBooking($id)
    {
        $booking = Booking::FindOrFail($id);

        if($booking->delete()) {
            return response()->json([
                'message' => 'Booking deleted successfully'
            ], 202);
        }
        else {
            return response()->json([
                'message' => 'Unable to delete Booking'
            ], 400);
        }
    }
}