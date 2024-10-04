<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('category', 'user')->get();
        $expense_categories = ExpenseCategory::all();
        $users = User::all();
        return view('expense.index', compact('users', 'expense_categories', 'expenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'expense_date' => 'required|date',
        ]);
        $expense = Expense::create([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'expense_date' => $request->expense_date,
        ]);
        if ($request->filled('user_id')) {
            $expense->user_id = $request->user_id;
            $expense->save();
        }
        return redirect()->route('expenses.index')->with('success', 'Expense added successfully!');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully!');
    }
}
