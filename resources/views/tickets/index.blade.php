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
                            <h3 class="card-title fs-4 fw-semibold">Tickets</h3>
                            <div>
                                @can('permission', 'ticket_create')
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#add-ticket-modal"><i
                                            class="fa fa-plus-circle me-2"></i>Add Ticket</button>
                                @endcan
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="row">
                            @foreach ($tickets as $ticket)
                                <div class="col-md-6 col-xl-3">
                                    <div class="card border shadow-md">
                                        <div class="card-body">
                                            <div class="favorite-icon">
                                                <a href="/job-grid"><i class="uil uil-heart-alt fs-18"></i></a>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="fs-17 mb-2">
                                                    <a class="text-dark" href="/job-details">{{ $ticket->subject }}</a>
                                                </h5>
                                                <div class="ms-2 dropdown">
                                                    <a href="#" class="text-muted dropdown-toggle"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @if (auth()->user()->id == $ticket->user_id || in_array(auth()->user()->designation_id, [1, 2, 3, 11]))
                                                            <li><a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-ticket"
                                                                    class="dropdown-item edit-ticket"
                                                                    data-id="{{ $ticket->id }}">edit
                                                                    ticket</a></li>
                                                        @endif
                                                        @if (in_array(auth()->user()->designation_id, [1, 2, 3]))
                                                            <li><a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#updateStatus"
                                                                    class="dropdown-item update-ticket-status"
                                                                    data-id="{{ $ticket->id }}"
                                                                    class="dropdown-item">update
                                                                    Status</a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <p class="text-muted fs-14 mb-1">Assigned to:
                                                        {{ ($ticket->assigned_to == 1 ? 'Admin' : $ticket->assigned_to == 2) ? 'Finance' : 'IT' }}
                                                    </p>
                                                </li>
                                                <li class="list-inline-item">
                                                    <p class="text-muted fs-14 mb-0"><i class="mdi mdi-message"></i>
                                                        {{ $ticket->responses_count }}</p>
                                                </li>
                                            </ul>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <p class="text-muted fs-14 mb-1">Created At:
                                                        {{ $ticket->created_at->format('M , Y d') }}</p>
                                                </li>
                                            </ul>
                                            <div class="mt-3 hstack gap-2">
                                                @php
                                                    if ($ticket->status == 1) {
                                                        $class = 'warning';
                                                        $status = 'Open';
                                                    } elseif ($ticket->status == 2) {
                                                        $class = 'info';
                                                        $status = 'In Progress';
                                                    } elseif ($ticket->status == 3) {
                                                        $class = 'success';
                                                        $status = 'Resolved';
                                                    } elseif ($ticket->status == 4) {
                                                        $class = 'danger';
                                                        $status = 'Closed';
                                                    }
                                                @endphp
                                                <span
                                                    class="badge rounded-1 badge-soft-{{ $class }}">{{ $status }}</span>
                                            </div>
                                            {{-- <div class="mt-4 hstack gap-2">
                                                <a href="#" data-id="" class="btn btn-soft-primary w-100" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">View details</a>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Add Ticket Modal -->
        <div class="modal fade" id="add-ticket-modal" tabindex="-1" aria-labelledby="add-ticket-modal-label"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add-ticket-modal-label">Add New Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12 mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject"
                                        placeholder="Enter the subject..." required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter the description..."
                                        required></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select class="form-select" id="priority" name="priority" required>
                                        <option value="1">Low</option>
                                        <option value="2">Medium</option>
                                        <option value="3">High</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="assigned_to" class="form-label">Assign To</label>
                                    <select class="form-select" id="assigned_to" name="assigned_to" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="image" class="form-label">Attachment (Optional)</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Ticket</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit-ticket" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Ticket</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="edit-modal-body">

                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="updateStatus" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('update.tickets.status') }}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Ticket Status</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="ticket_id" id="ticket_id">
                            <div class="col-md-12 mb-3">
                                <label for="update-status" class="form-label">Status</label>
                                <select class="form-select" id="update-status" name="status" required>
                                    <option value="1">Open</option>
                                    <option value="2">In Progress</option>
                                    <option value="3">Resolved</option>
                                    <option value="4">Closed</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="modal-body-detail">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('.edit-ticket').click(function() {
                    let id = $(this).data('id');
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get.ticket.data') }}",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            console.log(response)
                            $('#edit-modal-body').html(response)
                        }
                    });
                });
            });
            $('.update-ticket-status').click(function() {
                let id = $(this).data('id');
                $('#ticket_id').val(id);
            });
        </script>
    @endsection
