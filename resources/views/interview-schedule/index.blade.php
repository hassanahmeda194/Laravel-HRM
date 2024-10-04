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
                        <h3 class="card-title fs-4 fw-semibold">Schedule Interview</h3>
                        <div>
                            @can('permission' , 'interview_schedule_create')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#add-interview"><i class="fa fa-plus-circle me-2"></i>Schedule now</button>
                            @endcan
                        </div>
                    </div>
                    <hr>
                    <br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Candidate Name</th>
                                <th>Schedule time</th>
                                <th>Interview type</th>
                                <th>Status</th>
                                <th>interviewer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scheduleInterviews as $interview)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $interview->candidate->name }}</td>
                                    <td>{{ $interview->interview_datetime }}</td>

                                    <td>
                                        @if ($interview->interview_type == 1)
                                            <span class="badge badge-pill badge-soft-info fs-6">Onsite</span>
                                        @else
                                            <span class="badge badge-pill badge-soft-warning fs-6">Online</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($interview->status == 1)
                                            <span class="badge badge-pill badge-soft-info fs-6">Scheduled</span>
                                        @elseif ($interview->status == 2)
                                            <span class="badge badge-pill badge-soft-success fs-6">Completed</span>
                                        @elseif ($interview->status == 3)
                                            <span class="badge badge-pill badge-soft-warning fs-6">On hold</span>
                                        @endif
                                    </td>
                                    <td>{{ $interview->interviewer->name }}</td>
                                    <td>
                                         @can('permission' , 'interview_schedule_update')
                                        <button data-id="{{ $interview->id }}" class="btn btn-primary btn-sm mr-2 edit-btn">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        @endcan
                                         @can('permission' , 'interview_schedule_delete')
                                         <a href="{{ route('interview.schedule.destroy', ['id' => $interview->id]) }}"
                                            class="btn btn-danger btn-sm mr-2 ">
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

    <!-- Add Interview Modal -->
    <div id="add-interview" class="modal fade" tabindex="-1" aria-labelledby="add-interview-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('interview.schedule.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Scheduled Inteview</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Candidate</label>
                                    <select name="candidate_id" class="form-select">
                                        <option disabled selected>Select Candidate</option>
                                        @foreach ($candidates as $candidate)
                                            <option value="{{ $candidate->id }}">{{ $candidate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4  mb-3">
                                <div class="form-group">
                                    <label class="form-label">Schedule Time</label>
                                    <input type="datetime-local" class="form-control" placeholder="Add Amount"
                                        name="interview_datetime">
                                </div>
                            </div>
                            <div class="col-md-4  mb-3">
                                <div class="form-group">
                                    <label class="form-label">Interview Type</label>
                                    <select name="interview_type" class="form-select">
                                        <option value="1" selected>OnSite</option>
                                        <option value="2">Online</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4  mb-3">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="1" selected>Scheduled</option>
                                        <option value="2">Complete</option>
                                        <option value="3">On Hold</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4  mb-3">
                                <div class="form-group">
                                    <label class="form-label">Interviewer</label>
                                    <select class="form-select" name="interviewer_id">
                                        @foreach ($interviewers as $interviewer)
                                            <option value="{{ $interviewer->id }}">{{ $interviewer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block">Scheduled Interview</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Edit Interview Modal -->
    <div id="edit-interview" class="modal fade" tabindex="-1" aria-labelledby="edit-interview-label" aria-hidden="true">
        @include('partials.modals.edit-interview')
    </div>
    <script>
        $('.edit-btn').click(function(e) {
            e.preventDefault();
            var interviewId = $(this).data('id');
            var url = "{{ route('interview.schedule.edit') }}";
            $.ajax({
                url: url,
                method: "GET",
                data: {
                    id: interviewId
                },
                success: function(response) {
                    $('#edit-interview').html(response);
                    $('#edit-interview').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
