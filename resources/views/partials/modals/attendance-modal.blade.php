@if (isset($attendance))
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mark Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('attendance.update') }}" method="POST">
                @csrf
                <div class="modal-body row">
                    <input type="hidden" name="user_id" id="user_id" value="{{ $attendance->user_id }}">
                    <input type="hidden" name="created_at" id="created_at" value="{{ $attendance->created_at }}">
                    <div class="col-6">
                        <label for="" class="form-label">Check In</label>
                        <input type="time" name="check_in" class="form-control" required id="check_in"
                            value="{{ $attendance->check_in }}">
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">Check Out</label>
                        <input type="time" name="check_out" class="form-control" required id="check_out"
                            value="{{ $attendance->check_out }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect" name="mark_half_day" value="1">Mark
                        Half
                        Day</button>
                    <button type="submit" class="btn btn-primary waves-effect" name="mark_full_day" value="1">Mark
                        Attendance</button>
                </div>
            </form>
        </div>
    </div>
@endif
