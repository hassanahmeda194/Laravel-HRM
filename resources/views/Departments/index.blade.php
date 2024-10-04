@extends('Layout.master')
@section('main_section')
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
                        <h3 class="card-title fs-4 fw-semibold">Units</h3>
                        <div>
                            @can('permission', 'department_create')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#importExcel">
                                    Import Into Excle
                                </button>
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                    data-bs-target="#myModal"><i class="fa fa-plus-circle me-2"></i>New Units</button>
                            @endcan
                        </div>
                    </div>
                    <hr>
                    <br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Unit</th>
                                <th>Employee Count</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $department->users_count }}</td>
                                    <td>
                                        @if ($department->is_active)
                                            <span class="badge badge-pill badge-soft-success">Active</span>
                                        @else
                                            <span class="badge badge-pill badge-soft-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm edit-department" href="#"
                                            data-id="{{ $department->id }}">
                                            <i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger btn-sm"
                                            href="{{ route('department.delete', ['id' => $department->id]) }}">
                                            <i class="fa fa-trash"></i></a>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add New Units</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('department.store') }}" method="POST">
                        @csrf
                        <div class="modal-body row">
                            <div class="col-6">
                                <label for="" class="form-label">Unit name</label>
                                <input type="text" name="department_name" class="form-control"
                                    placeholder="Enter Unit name" required>
                            </div>
                            <div class="col-6 mt-4 pt-2">
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd" checked
                                        name="is_active" value="1">
                                    <label class="form-check-label" for="SwitchCheckSizemd">is active</label>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Add
                                Department</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Edit Units</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('department.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="d_id">
                        <div class="modal-body row">
                            <div class="col-6">
                                <label for="" class="form-label">Units name</label>
                                <input type="text" name="department_name" class="form-control"
                                    placeholder="Enter Unit name" required id="department_name">
                            </div>
                            <div class="col-6 mt-4 pt-2">
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input class="form-check-input is_active" type="checkbox" id="SwitchCheckSizemd"
                                        name="is_active" value="1">
                                    <label class="form-check-label" for="SwitchCheckSizemd">is active</label>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">update
                                Units</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.edit-department').click(function(e) {
            e.preventDefault();
            var departmentId = $(this).data('id');
            var url = "{{ route('department.edit') }}";
            $.ajax({
                url: url,
                method: "GET",
                data: {
                    id: departmentId
                },
                success: function(response) {
                    $('#department_name').val(response.department.name);
                    $('#d_id').val(response.department.id);
                    $('.is_active').prop('checked', response.department.is_active == 1);
                    $('#editModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
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
                        <a href="{{ asset('import/department.xlsx') }}" class="btn btn-sm btn-primary" download="">
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                    <div class="mt-4">
                        <form action="{{ route('import.department') }}" method="POST" enctype="multipart/form-data">
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
