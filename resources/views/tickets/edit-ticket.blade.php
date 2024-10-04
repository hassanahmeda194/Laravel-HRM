<div class="modal-body">
    <form action="{{ route('tickets.update', ['id' => $ticket->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-12 mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject"
                        placeholder="Enter the subject..." value="{{ $ticket->subject }}" required>
                </div>
                <div class="col-12 mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter the description..."
                        required>{{ $ticket->description }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select class="form-select" id="priority" name="priority" required>
                        <option value="1" @selected($ticket->priority == 1)>Low</option>
                        <option value="2" @selected($ticket->priority == 2)>Medium</option>
                        <option value="3" @selected($ticket->priority == 3)>High</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="assigned_to" class="form-label">Assign To</label>
                    <select class="form-select" id="assigned_to" name="assigned_to" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected($ticket->assigned_to == $user->id)>{{ $user->name }}
                            </option>
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
            <button type="submit" class="btn btn-primary">update Ticket</button>
        </div>
    </form>
</div>
