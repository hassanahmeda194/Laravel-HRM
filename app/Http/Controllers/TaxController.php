<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taxes = Tax::all();
        return view('tax.index', compact('taxes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rate' => 'required'
        ]);
        try {
            Tax::create([
                'name' => $request->name,
                'rate' => $request->rate
            ]);
            return back()->with('success', 'Tax Added successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Tax Added Failed!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tax $tax)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tax $tax)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tax $tax)
    {
        try {
            $tax->delete();
            return back()->with('success', 'Tax deleted successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Tax deleted Failed!');
        }
    }
}
