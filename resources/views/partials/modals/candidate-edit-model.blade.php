@isset($candidate)
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Candidate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('candidate.update', ['id' => $candidate->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body row">
                    <div class="col-4 mb-3">
                        <label for="" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required
                            value="{{ $candidate->name }}">
                    </div>
                    <div class="col-4 mb-3">
                        <label for="" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required
                            value="{{ $candidate->email }}">
                    </div>
                    <div class="col-4 mb-3">
                        <label for="" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone" required
                            value="{{ $candidate->phone }}">
                    </div>
                    <div class="col-4 mb-3">
                        <label for="" class="form-label">Resume Path</label>
                        <input type="file" name="resume_path" class="form-control" placeholder="Enter Resume Path">
                    </div>
                    <div class="col-4 mb-3">
                        <label for="" class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="1" @selected($candidate->status == 1)>In Process</option>
                            <option value="2" @selected($candidate->status == 2)>Selected</option>
                            <option value="3" @selected($candidate->status == 3)>Rejected</option>
                            <option value="4" @selected($candidate->status == 4)>On Hold</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="" class="form-label">Address</label>
                        <textarea name="address" rows="4" class="form-control">{{ $candidate->address }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary waves-effect waves-light" type="submit">Update Candidate</button>
                </div>
            </form>
        </div>
    </div>
@endisset
