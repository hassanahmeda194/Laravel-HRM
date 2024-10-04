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
                        <h3 class="card-title fs-4 fw-semibold">Leave Request</h3>
                        <div>
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                data-bs-target="#add-candidate"><i class="fa fa-plus-circle me-2"></i> Add request
                                Board</button>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Start date</th>
                                <th>end date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $request)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $request->title }}</td>
                                    <td>{{ Str::words($request->description, 5, '...') }}</td>
                                    <td>
                                        @if ($request->status == 1)
                                            <span class="badge badge-pill badge-soft-success">Approved</span>
                                        @elseif ($request->status == 0)
                                            <span class="badge badge-pill badge-soft-danger">Rejected</span>
                                        @elseif ($request->status == 2)
                                            <span class="badge badge-pill badge-soft-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                                    </td>
                                    <td>
                                        @if (!in_array($request->status, [0, 1]))
                                            <button data-id="{{ $request->id }}"
                                                class="btn btn-primary btn-sm mr-2 edit-btn">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <a href="{{ route('leave.request.delete', ['id' => $request->id]) }}"
                                                class="btn btn-danger btn-sm mr-2">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endif
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
                        <h5 class="modal-title" id="myModalLabel">Leave Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('leave.request.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body row">
                            <small class="text-primary mb-3">If you request a leave for one day, the start and end dates
                                should
                                be the same.</small>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter your Title"
                                    required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="" class="form-label">Leave Type</label>
                                <select name="leave_type" id="" class="form-select">
                                    <option value="sick_leave">Sick</option>
                                    <option value="casual_leave">Casual</option>
                                    <option value="annual_leave">Auunal</option>
                                    <option value="unpaid_leave">Unpaid</option>
                                </select>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="" class="form-label">Start date</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="" class="form-label">End date</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Reason</label>
                                <textarea name="description" rows="4" class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Add request
                                Board</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            {{-- @include('partials.modals.request-board-edit') --}}
        </div>

    </div>
    <script>
        $('.edit-btn').click(function(e) {
            e.preventDefault();
            var requestId = $(this).data('id');
            var url = "{{ route('leave.request.edit') }}";
            $.ajax({
                url: url,
                method: "GET",
                data: {
                    id: requestId
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
@endsection
