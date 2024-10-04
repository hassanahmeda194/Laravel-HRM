@isset($request)
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Leave Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('leave.request.update', ['id' => $request->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body row">
                    <small class="text-primary mb-3">If you request a leave for one day, the start and end dates
                        should
                        be the same.</small>
                    <div class="col-12 mb-3">
                        <label for="" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter your Title" required
                            value="{{ $request->title }}">
                    </div>
                    <div class="col-4 mb-3">
                        <label for="" class="form-label">Leave Type</label>
                        <select name="leave_type" id="" class="form-select">
                            <option value="sick_leave" @selected($request->leave_type == 'sick_leave')>Sick</option>
                            <option value="casual_leave" @selected($request->leave_type == 'casual_leave')>Casual</option>
                            <option value="annual_leave" @selected($request->leave_type == 'annual_leave')>Auunal</option>
                            <option value="unpaid_leave" @selected($request->leave_type == 'unpaid_leave')>Unpaid</option>
                        </select>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="" class="form-label">Start date</label>
                        <input type="date" name="start_date" class="form-control" required
                            value="{{ $request->start_date }}">
                    </div>
                    <div class="col-4 mb-3">
                        <label for="" class="form-label">End date</label>
                        <input type="date" name="end_date" class="form-control" required
                            value="{{ $request->end_date }}">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="" class="form-label">Reason</label>
                        <textarea name="description" rows="4" class="form-control">{{ $request->description }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary waves-effect waves-light" type="submit">Update Leave Request</button>
                </div>
            </form>
        </div>
    </div>
@endisset
