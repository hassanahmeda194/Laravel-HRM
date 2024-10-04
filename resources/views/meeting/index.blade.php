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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title fs-4 fw-semibold">Meetings</h3>
                        <div>
                            @can('permission', 'meeting_create')
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                    data-bs-target="#add-meeting"><i class="fa fa-plus-circle me-2"></i> Add Meeting</button>
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
                                <th>Date & Time</th>
                                <th>Arranged By</th>
                                <th>Perticipents</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($meetings as $meeting)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $meeting->title }}</td>
                                    <td>{{ Str::words($meeting->description, 5, '...') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($meeting->date_time)->format('M d, Y h:i A') }}</td>
                                    <td>{{ $meeting->arranger->name }}</td>
                                    <td>
                                        @foreach ($meeting->participants as $index => $participant)
                                            {{ $participant->user->name }}{{ $loop->last ? '' : ',' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @can('permission', 'meeting_update')
                                            <button data-id="{{ $meeting->id }}" class="btn btn-primary btn-sm mr-2 edit-btn">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        @endcan
                                        @can('permission', 'meeting_delete')
                                            <a href="{{ route('meetings.destroy', ['id' => $meeting->id]) }}"
                                                class="btn btn-danger btn-sm mr-2"
                                                onclick="return confirm('Are you sure you want to delete this meeting?');">
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
        <div id="add-meeting" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add Meeting</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('meetings.store') }}" method="POST">
                        @csrf
                        <div class="modal-body row">
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter meeting title"
                                    required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Description</label>
                                <textarea name="description" rows="4" class="form-control" placeholder="Enter meeting description"></textarea>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">Date & Time</label>
                                <input type="datetime-local" name="date_time" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">Arranged By</label>
                                <select name="arranged_by" class="form-select">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 my-3 ">
                                <h5 class="mb-4">Arranged With</h5>
                                <div class="row mx-1">
                                    @foreach ($users as $user)
                                        <div class="form-check col-3">
                                            <input class="form-check-input" type="checkbox" name="arranged_with[]"
                                                value="{{ $user->id }}" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ $user->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Add Meeting</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            {{-- @include('partials.modals.meeting-edit') --}}
        </div>
    </div>

    <script>
        $('.edit-btn').click(function(e) {
            e.preventDefault();
            var meetingId = $(this).data('id');
            console.log(meetingId);
            var url = "{{ route('meetings.edit') }}";
            $.ajax({
                url: url,
                method: "GET",
                data: {
                    id: meetingId
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
