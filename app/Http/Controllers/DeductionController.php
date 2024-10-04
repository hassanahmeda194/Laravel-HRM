<?php

namespace App\Http\Controllers;

use App\Models\Deduction;
use Exception;
use Illuminate\Http\Request;

class DeductionController extends Controller
{

    public function index()
    {
        $deductions = Deduction::all();
        return view('Deduction.index', compact('deductions'));
    }

    public function edit(Request $request)
    {
        try {
            return response()->json(Deduction::find($request->id));
        } catch (\Exception $e) {
            return back()->with('error', 'Error occurred while processing the request');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->toArray());
        try {
            Deduction::find($request->id)->update([
                'detact_amount' => $request->deduct_amount
            ]);
            return back()->with('success', 'Detact Amount Updated Successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Detact Amount Failed!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
