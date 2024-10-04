@extends('Layout.master')
@section('main_section')
    <style>
        input:disabled {
            background-color: rgb(179, 178, 178) !important;
            color: #a0a0a0;
            cursor: not-allowed;
        }

        select:disabled {
            background-color: rgb(179, 178, 178) !important;
            color: #a0a0a0;
            cursor: not-allowed;
        }
    </style>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title fs-4 fw-semibold">Allowances</h3>
                        <div>
                            @can('permission', 'allowance_create')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#importExcel">
                                    Import Into Excle
                                </button>
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                    data-bs-target="#myModal"><i class="fa fa-plus-circle me-2"></i> Add Allowance</button>
                            @endcan
                        </div>
                    </div>
                    <hr>
                    <br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>allowance name</th>
                                <th>amount</th>
                                <th>month</th>
                                <th>every month</th>
                                <th>username</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allowances as $allowance)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $allowance->name }}</td>
                                    <td>{{ number_format($allowance->amount, 2) }}</td>
                                    <td>{{ $allowance->month ?? '-' }}</td>
                                    <td>{{ $allowance->every_month ? 'Yes' : 'No' }}</td>
                                    <td>{{ $allowance->user->name }}</td>
                                    <td>
                                        @can('permission', 'allowance_delete')
                                            <a class="btn btn-sm btn-danger"
                                                href="{{ route('allowance.delete', ['id' => $allowance->id]) }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('allowance.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Allowance</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Allowance Name</label>
                                    <input class="form-control" placeholder="Add Allowance Name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Amount</label>
                                    <input type="number" class="form-control" placeholder="Add Amount" name="amount"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3" id="month-field">
                                <div class="form-group">
                                    <label class="form-label">Month</label>
                                    <input type="month" class="form-control" placeholder="Select Month" name="month">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check pt-1">
                                    <input class="form-check-input mt-2" type="checkbox" value="1"
                                        id="every-month-check" name="every_month">
                                    <label class="form-check-label text-black pt-1" for="every-month-check pt-1">Every
                                        Month</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3" id="all-employee">
                                <label class="form-label">All Employee</label>
                                <select class="form-select" id="employee-dropdown" name="user_id">
                                    <option selected disabled>Select Employee</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check pt-1">
                                    <input class="form-check-input mt-2" type="checkbox" value="1"
                                        id="all-employee-check" name="all_employee">
                                    <label class="form-check-label text-black pt-1" for="all-employee-check pt-1">All
                                        Employee</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block">Add Allowance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            function updateFields() {
                let allEmployeeChecked = $('#all-employee-check').is(':checked');
                let everyMonthChecked = $('#every-month-check').is(':checked');

                if (allEmployeeChecked) {
                    $('#employee-dropdown').prop('disabled', true);
                } else {
                    $('#employee-dropdown').prop('disabled', false);
                }

                if (everyMonthChecked) {
                    $('#month-field input').prop('disabled', true);
                } else {
                    $('#month-field input').prop('disabled', false);
                }
            }
            updateFields();

            $('#all-employee-check, #every-month-check').change(function() {
                updateFields();
            });
        });
    </script>

    <div class="modal fade" id="importExcel" tabindex="-1" aria-labelledby="importExcelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="importExcelLabel">Import Excel File</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>To correctly import data, download the demo file to understand the required fields:</p>
                    <div class="border border-dark rounded d-flex justify-content-between align-items-center py-2 px-3">
                        <span>Demo File</span>
                        <a href="{{ asset('import/allowance.xlsx') }}" class="btn btn-sm btn-primary" download="">
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                    <div class="mt-4">
                        <form action="{{ route('import.allowance') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="importFile" class="form-label">Select File to Import</label>
                                <input type="file" class="form-control" id="importFile" name="file" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Import File</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
