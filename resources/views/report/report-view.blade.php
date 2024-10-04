<div class="card">
    <div class="card-body">
        <div class="mb-4 border-bottom">
            <h4>Report</h4>
        </div>
        @if ($data['allowances']->isNotEmpty())
            <div class="">
                <div class="mb-4">
                    <h4>Allowance</h4>
                </div>
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-secondary">
                                <th>Sno</th>
                                <th>Allowance name</th>
                                <th>Month</th>
                                <th>Every Month</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['allowances'] as $allowance)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $allowance->name }}</td>
                                    <td>{{ $allowance->month ?? '-' }}</td>
                                    <td>{{ $allowance->every_month == 1 ? 'Yes' : 'No' }}</td>
                                    <td>{{ $allowance->amount }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-secondary">
                                <td colspan="4">Total</td>
                                <td>{{ $data['allowances']->sum('amount') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if ($data['expenses']->isNotEmpty())
            <div class="">
                <div class="mb-4">
                    <h4>Expense</h4>
                </div>
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-secondary">
                                <th>Sno</th>
                                <th>Category</th>
                                <th>User</th>
                                <th>Name</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['expenses'] as $expense)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $expense->category->name }}</td>
                                    <td>{{ $expense->user->name ?? '-' }}</td>
                                    <td>{{ $expense->description ?? '-' }}</td>
                                    <td>{{ $expense->amount }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-secondary">
                                <td colspan="4">Total</td>
                                <td>{{ $data['expenses']->sum('amount') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if ($data['employees']->isNotEmpty())
            <div class="">
                <div class="mb-4">
                    <h4>Users</h4>
                </div>
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-secondary">
                                <th>Sno</th>
                                <th>Name</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['employees'] as $employee)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->employement_info->salary ?? '-' }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-secondary">
                                <td colspan="2">Total</td>
                                <td>
                                    {{ $data['employees']->sum(function ($employee) {
                                        return $employee->employement_info->salary ?? 0;
                                    }) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if ($data['allowances']->isNotEmpty() || $data['expenses']->isNotEmpty() || $data['employees']->isNotEmpty())
            <table class="table table-bordered">
                <thead>
                    <tr class="table-secondary">
                        <th colspan="2">Grand Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Allowance:</td>
                        <td>{{ $data['allowances']->sum('amount') }}</td>
                    </tr>
                    <tr>
                        <td>Total Expense:</td>
                        <td>{{ $data['expenses']->sum('amount') }}</td>
                    </tr>
                    <tr>
                        <td> Total Salary:</td>
                        <td> {{ $data['employees']->sum(function ($employee) {
                            return $employee->employement_info->salary ?? 0;
                        }) }}
                        </td>
                    </tr>
                    <tr class="table-secondary">
                        <td>Total</td>
                        <td> {{ $data['allowances']->sum('amount') +
                            $data['expenses']->sum('amount') +
                            $data['employees']->sum(function ($employee) {
                                return $employee->employement_info->salary ?? 0;
                            }) }}
                        </td>
                    </tr>
                </tbody>
            </table>
      
        @endif
    </div>
</div>
