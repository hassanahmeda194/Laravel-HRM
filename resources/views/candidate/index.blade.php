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
                        <h3 class="card-title fs-4 fw-semibold">Candidate</h3>
                        <div>
                            @can('permission', 'candidate_create')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#importExcel">
                                    Import Into Excle
                                </button>
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                    data-bs-target="#add-candidate"><i class="fa fa-plus-circle me-2"></i> Add
                                    Candidate</button>
                            @endcan
                        </div>
                    </div>
                    <hr>
                    <br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone#</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidates as $candidate)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $candidate->name }}</td>
                                    <td>{{ $candidate->email }}</td>
                                    <td>{{ $candidate->phone }}</td>
                                    <td>
                                        @if ($candidate->status == 1)
                                            <span class="badge badge-pill badge-soft-info">In Progress</span>
                                        @elseif ($candidate->status == 2)
                                            <span class="badge badge-pill badge-soft-success">Selected</span>
                                        @elseif ($candidate->status == 3)
                                            <span class="badge badge-pill badge-soft-danger">Rejected</span>
                                        @elseif ($candidate->status == 4)
                                            <span class="badge badge-pill badge-soft-warning">On Hold</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('permission', 'candidate_update')
                                            <button data-id="{{ $candidate->id }}" class="btn btn-primary btn-sm mr-2 edit-btn">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        @endcan
                                        @can('permission', 'candidate_delete')
                                            <a href="{{ route('candidate.delete', ['id' => $candidate->id]) }}"
                                                class="btn btn-danger btn-sm mr-2">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endcan
                                        <a href="{{ asset($candidate->resume_path) }}" class="btn btn-success btn-sm mr-2"
                                            download="">
                                            <i class="fa fa-download"></i>
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
        <div id="add-candidate" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add New Candidate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('candidate.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body row">
                            <div class="col-4 mb-3">
                                <label for="" class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Full Name"
                                    required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email"
                                    required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter Phone"
                                    required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="" class="form-label">Resume Path</label>
                                <input type="file" name="resume_path" class="form-control"
                                    placeholder="Enter Resume Path">
                            </div>
                            <div class="col-4 mb-3">
                                <label for="" class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="1" selected>In Process</option>
                                    <option value="2">Selected</option>
                                    <option value="3">Rejected</option>
                                    <option value="4">On Hold</option>
                                </select>

                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Address</label>
                                <textarea name="address" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Add Candidate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            @include('partials.modals.candidate-edit-model')
        </div>

    </div>
    <script>
        $('.edit-btn').click(function(e) {
            e.preventDefault();
            var candidateId = $(this).data('id');
            var url = "{{ route('candidate.edit') }}";
            $.ajax({
                url: url,
                method: "GET",
                data: {
                    id: candidateId
                },
                success: function(response) {
                    $('#editModal').html(response);
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
                        <a href="{{ asset('import/candidate.xlsx') }}" class="btn btn-sm btn-primary" download="">
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                    <div class="mt-4">
                        <form action="{{ route('import.candidate') }}" method="POST" enctype="multipart/form-data">
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
