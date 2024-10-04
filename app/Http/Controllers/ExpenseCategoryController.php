<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expense_category = ExpenseCategory::whereMonth('created_at', now())->get();
        return view('expense.category.index', compact('expense_category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);
            ExpenseCategory::create($validatedData);
            return back()->with('success', "Expense Category Added successfully!");
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', "Expense Category Added Failed!");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        try {
            $expenseCategory->delete();
            return redirect()->route('expense-categories.index')->with('success', 'Expense Category deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('expense-categories.index')->with('error', 'Failed to delete the Expense Category!');
        }
    }
}
