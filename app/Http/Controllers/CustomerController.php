<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class CustomerController extends Controller
{
    /** 
     * Display all customers
    */

    public function showAllCustomers(Request $request)
    {
        $customer = Customer::all();
        return response()->json($customer, 200);
    }

    /** 
     * Create new customer
    */

    public function createCustomer(Request $request)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|min:1',
            'firstname' => 'required|string',
            'surname' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        $customer = Customer::create($request->all());

        if($request->user_id && $request->user_id>0) {
            $user = $customer->user;
            $user->customer_id = $customer->id;
            
            if($user->save()) {
                return response()->json([
                    'customer' => $customer,
                    'message' => 'Customer successfully created'
                ], 201);
            }
            else {
                return response()->json([
                    'message' => 'Unable to create Customer'
                ], 422);
            }
        }
    }

    /** 
     * Display the specified customer
    */

    public function getCustomer($id)
    {
        $customer = Customer::FindOrFail($id);
        return response()->json($customer, 200);
    }

    /** 
     * Update Customer
    */

    public function updateCustomer(Request $request, $id)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|min:1',
            'firstname' => 'required|string',
            'surname' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        //$customer->fill($request->all());

        if($customer->update($request->all())) {
            return response()->json([
                'customer' => $customer,
                'message' => 'Customer updated successfully'
            ], 202);
        }
        else {
            return response()->json([
                'error' => 'Unable to update customer'
            ], 400);
        }
    }
    
    /**
     * Delete Customer
    */

     public function deleteCustomer($id)
     {
        $customer = Customer::FindOrFail($id);

        if($customer->delete()) {
            return response()->json([
                'message' => 'Customer deleted successfully'
            ], 202);
        }
        else {
            return response()->json([
                'message' => 'Unable to delete Customer'
            ], 400);
        }
     }
}