<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('crm.customer.index', compact('customers'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country' => 'required',
        ]);
        try {
            Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'country' => $request->country,
                'phone_number' => $request->phone_number,
                'address' => $request->address
            ]);
            return back()->with('success', 'customer added successfully!');
        } catch (\Throwable $th) {
            return back()->with('success', 'customer added Failed!' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        try {
            return view('crm.customer.edit', ['customer' => $customer])->render();
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'country' => 'required',
        ]);
        try {
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'country' => $request->country,
                'phone_number' => $request->phone_number,
                'address' => $request->address
            ]);
            return back()->with('success', 'customer updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('success', 'customer updated Failed!',  $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return back()->with('success', "customer deleted successfully!");
        } catch (\Throwable $th) {
            return back()->with('success', "customer deleted Failed!" . $th->getMessage());
        }
    }
}
