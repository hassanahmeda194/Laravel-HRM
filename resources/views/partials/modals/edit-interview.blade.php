@isset($scheduleInterview)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('interview.schedule.update', ['id' => $scheduleInterview->id]) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit Schedule Interview</h5>
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
                                        <option value="{{ $candidate->id }}" @selected($scheduleInterview->candidate_id)>
                                            {{ $candidate->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4  mb-3">
                            <div class="form-group">
                                <label class="form-label">Schedule Time</label>
                                <input type="datetime-local" class="form-control" placeholder="Add Amount"
                                    name="interview_datetime" value="{{ $scheduleInterview->interview_datetime }}">
                            </div>
                        </div>
                        <div class="col-md-4  mb-3">
                            <div class="form-group">
                                <label class="form-label">Interview Type</label>
                                <select name="interview_type" class="form-select">
                                    <option value="1" @selected($scheduleInterview->interview_type == 1)>OnSite</option>
                                    <option value="2" @selected($scheduleInterview->interview_type == 2)>Online</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4  mb-3">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="1" @selected($scheduleInterview->status == 1)>Scheduled</option>
                                    <option value="2" @selected($scheduleInterview->status == 2)>Complete</option>
                                    <option value="3" @selected($scheduleInterview->status == 3)>On Hold</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4  mb-3">
                            <div class="form-group">
                                <label class="form-label">Interviewer</label>
                                <select class="form-select" name="interviewer_id">
                                    @foreach ($interviewers as $interviewer)
                                        <option value="{{ $interviewer->id }}" @selected($scheduleInterview->interviewer_id == $interviewer->id)>
                                            {{ $interviewer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-block">Update Scheduled Interview</button>
                </div>
            </form>

        </div>
</div>@endisset
