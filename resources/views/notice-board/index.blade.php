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
                        <h3 class="card-title fs-4 fw-semibold">Notice Board</h3>
                        <div>
                            @can('permission' , 'notice_board_create')
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                data-bs-target="#add-candidate"><i class="fa fa-plus-circle me-2"></i> Add Notice
                                Board</button>
                            @endcan
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
                                <th>date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notices as $notice)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $notice->title }}</td>
                                    <td>{{ Str::words($notice->description, 5, '...') }}</td>
                                    <td>
                                        <span class="{{ $notice->status }} font-size-12">status</span>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($notice->date)->format('M d, Y') }}
                                    </td>
                                    <td>
                                        @can('permission' , 'notice_board_update')
                                        <button data-id="{{ $notice->id }}" class="btn btn-primary btn-sm mr-2 edit-btn">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        @endcan

                                         @can('permission' , 'notice_board_delete')
                                        <a href="{{ route('notice.board.delete', ['id' => $notice->id]) }}"
                                            class="btn btn-danger btn-sm mr-2">
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
    <div>
        <div id="add-candidate" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add New Notice Board</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('notice.board.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body row">
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Notice Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter your Title"
                                    required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">Status</label>
                                <select name="status" id="" class="form-select">
                                    <option value="badge badge-pill badge-soft-success">Success</option>
                                    <option value="badge badge-pill badge-soft-info">Info</option>
                                    <option value="badge badge-pill badge-soft-danger"> Danger</option>
                                    <option value="badge badge-pill badge-soft-warning">Warning</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">date</label>
                                <input type="date" name="date" class="form-control" placeholder="Enter Phone"
                                    required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">description</label>
                                <textarea name="description" rows="4" class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Add Notice
                                Board</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            @include('partials.modals.notice-board-edit')
        </div>

    </div>
    <script>
        $('.edit-btn').click(function(e) {
            e.preventDefault();
            var noticeId = $(this).data('id');
            var url = "{{ route('notice.board.edit') }}";
            $.ajax({
                url: url,
                method: "GET",
                data: {
                    id: noticeId
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
