<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Expense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function generate_report(Request $request)
    {
        $data = [
            'allowances' => collect(),
            'expenses' => collect(),
            'employees' => collect(),
        ];

        if ($request->allowance == "true") {
            $allowances = Allowance::orWhere('every_month', 1)->get();
            $data['allowances'] = $allowances;
        }

        if ($request->expense == "true") {
            $expenses = Expense::with(['category', 'user'])->get();
            $data['expenses'] = $expenses;
        }

        if ($request->salaries == "true") {
            $employees = User::with('employement_info')->get();
            $data['employees'] = $employees;
        }

        return view('report.report-view', compact('data'));
    }
}
