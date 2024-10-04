@extends('Layout.master')
@section('main_section')
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            table-layout: ;
        }

        .table th,
        .table td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title fs-4 fw-semibold">All Employee</h3>
                        <div>

                            @can('permission', 'employee_create')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importExcel">
                                    Import Into Excle
                                </button>
                                <a href="{{ route('employee.create') }}" class="btn btn-primary"><i
                                        class="fa fa-plus-circle me-2"></i>Add new Employee</a>
                            @endcan
                        </div>
                    </div>
                    <hr>
                    <br>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>EMP ID</th>
                                    <th>Name</th>
                                    <th>DOJ</th>
                                    <th>Employee Status</th>
                                    <th>Designation</th>
                                    <th>CNIC</th>
                                    <th>Email</th>
                                    <th>Alternate Email</th>
                                    <th>Bank Name</th>
                                    <th>Bank Account</th>
                                    <th>Num</th>
                                    <th>Salary</th>
                                    <th>Vehicle</th>
                                    <th>Allowance</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Users as $User)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $User->Emp_Id ?? '-' }}</td>
                                        <td>{{ $User->name ?? '-' }}</td>
                                        <td>{{ $User->employment_info->joining_date ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge badge-pill badge-soft-{{ $User->is_active ? 'success' : 'danger' }}">
                                                {{ $User->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $User->designation->name ?? '-' }}</td>
                                        <td>{{ $User->employee_basic_info->cnic ?? '-' }}</td>
                                        <td>{{ $User->email ?? '-' }}</td>
                                        <td>{{ $User->employee_basic_info->personal_email ?? '-' }}</td>
                                        <td>{{ $User->bank_details->bank_name ?? '-' }}</td>
                                        <td>{{ $User->bank_details->account_number ?? '-' }}</td>
                                        <td>{{ $User->employee_basic_info->phone_number ?? '-' }}</td>
                                        <td>{{ $User->employment_info->salary ?? '-' }}</td>
                                        <td>{{ $User->vehicle ?? '-' }}</td>
                                        <td>{{ $User->allowance ?? '-' }}</td>
                                        <td>{{ $User->employee_basic_info->address ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge badge-pill badge-soft-{{ $User->is_active ? 'success' : 'danger' }}">
                                                {{ $User->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            @can('permission', 'employee_update')
                                                <a href="{{ route('employee.edit', ['id' => $User->id]) }}"
                                                    class="btn btn-outline-info btn-sm edit" title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endcan
                                            @can('permission', 'employee_delete')
                                                <a href="{{ route('employee.delete', ['id' => $User->id]) }}"
                                                    class="btn btn-outline-danger btn-sm edit" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
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
    </div>
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
                        <a href="{{ asset('import/employee.xlsx') }}" class="btn btn-sm btn-primary" download="">
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                    <div class="mt-4">
                        <form action="{{ route('import.employee') }}" method="POST" enctype="multipart/form-data">
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
