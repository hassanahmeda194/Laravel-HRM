<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\User;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allowances =  Allowance::with('user')->get();
        $users = User::all();
        return view('Allowance.index', compact('allowances', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'user_id' => 'required_if:all_employee,false|exists:users,id', // Validate only if not applying to all employees
            'month' => 'nullable|date_format:Y-m',
        ]);

        try {
            $month = $request->filled('every_month') ? null : $request->input('month');
            $everyMonth = $request->filled('every_month');

            if ($request->filled('all_employee')) {
                $users = User::all();
                foreach ($users as $user) {
                    Allowance::create([
                        'month' => $month,
                        'every_month' => $everyMonth,
                        'name' => $request->input('name'),
                        'amount' => $request->input('amount'),
                        'user_id' => $user->id,
                    ]);
                }
            } else {
                Allowance::create([
                    'month' => $month,
                    'every_month' => $everyMonth,
                    'name' => $request->input('name'),
                    'amount' => $request->input('amount'),
                    'user_id' => $request->input('user_id'),
                ]);
            }

            return back()->with('success', 'Allowance added successfully!');
        } catch (\Exception $e) {
            \Log::error('Error adding allowance: ' . $e->getMessage()); // Log the error
            return back()->with('error', 'Failed to add allowance!');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Allowance::find($id)->delete();
            return back()->with('success', 'Allowance deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Allowance deleted Failed!');
        }
    }
}
