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
                        <h3 class="card-title fs-4 fw-semibold">Expense Categories</h3>
                        <div>
                            @can('permission', 'expenses_category_create')
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                    data-bs-target="#add-candidate"><i class="fa fa-plus-circle me-2"></i> Add Category</button>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expense_category as $cat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $cat->name }}</td>
                                    <td>
                                        @can('permission', 'expenses_category_delete')
                                            <form action="{{ route('expense-categories.destroy', $cat->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mr-2"
                                                    onclick="return confirm('Are you sure you want to delete this category?');">
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
    <div>
        <div id="add-candidate" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('expense-categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body row">
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Add Category</button>
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
@endsection
