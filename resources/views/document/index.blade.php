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
                        <div>
                            <h3 class="card-title fs-4 fw-semibold">Document Management</h3>
                        </div>
                        <div>
                            @can('permission', 'document_create')
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                    data-bs-target="#myModal"><i class="fa fa-plus-circle me-2"></i>Add Document</button>
                            @endcan
                        </div>
                    </div>
                    <hr>
                    <br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Document Name</th>
                                <th>User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $document->name }}</td>
                                    <td>{{ $document->user->name }}</td>
                                    <td>
                                        <a href="{{ asset($document->file_path) }}" class="btn btn-primary btn-sm"
                                            download=""><i class="fa fa-download"></i></a>
                                        @can('permission', 'document_delete')
                                            <form action="{{ route('document.destroy', $document->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
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
                <form action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Document</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Document Name</label>
                                    <input class="form-control" placeholder="Enter Document Name" name="name"
                                        id="document_name" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">User</label>
                                    <select name="user_id" id="user_id" class="form-select">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">File Path</label>
                                    <input type="file" class="form-control" placeholder="Enter File Path"
                                        name="file_path" id="file_path" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('.edit-document').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('document.edit') }}",
                method: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    $('#document_name').val(response.name);
                    $('#file_path').val(response.file_path);
                    $('#document_id').val(response.id);
                    $('#editDocumentModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
