@isset($designation)
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('designation.update', ['id' => $designation->id]) }}" method="POST">
                @csrf
                <div class="modal-body row">
                    <div class="col-6">
                        <label for="" class="form-label">Designation name</label>
                        <input type="text" name="designation_name" class="form-control" placeholder="Enter Role name"
                            required value="{{ $designation->name }}">
                    </div>
                    <div class="col-6">
                        <label for="formrow-inputState" class="form-label">Department Name</label>
                        <select id="formrow-inputState" class="form-select d_select" name="department_id" required>
                            <option value="" selected disabled hidden>Choose...</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected($designation->department_id == $department->id)>{{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mt-4 pt-2">
                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                            <input class="form-check-input is_active" type="checkbox" id="SwitchCheckSizemd"
                                name="is_active" value="1" @checked($designation->is_active == 1)>
                            <label class="form-check-label" for="SwitchCheckSizemd">is active</label>
                        </div>
                    </div>
                    @php
                        $permission = $designation->permissions;
                    @endphp
                    <div class="col-12 mt-4 pt-2">
                        <h4>Permissions</h4>
                        <br>
                        <table class="table table-bordered ">
                            <tr>
                                <th>Modules</th>
                                <th>View</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                                <th>Details</th>
                            </tr>
                            <tr>
                                <td>Employee</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="1"
                                        @checked($permission->contains('id', 1))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="2"
                                        @checked($permission->contains('id', 2))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="3"
                                        @checked($permission->contains('id', 3))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="4"
                                        @checked($permission->contains('id', 4))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="5"
                                        @checked($permission->contains('id', 5))>
                                </td>
                            </tr>
                            <tr>
                                <td>Department</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="6"
                                        @checked($permission->contains('id', 6))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="7"
                                        @checked($permission->contains('id', 7))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="8"
                                        @checked($permission->contains('id', 8))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="9"
                                        @checked($permission->contains('id', 9))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Designation</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="10"
                                        @checked($permission->contains('id', 10))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="11"
                                        @checked($permission->contains('id', 11))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="12"
                                        @checked($permission->contains('id', 12))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="13"
                                        @checked($permission->contains('id', 13))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Attendance</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="14"
                                        @checked($permission->contains('id', 14))>
                                </td>
                                <td></td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="15"
                                        @checked($permission->contains('id', 15))>
                                </td>
                                <td></td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td>Leaves</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="16"
                                        @checked($permission->contains('id', 16))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="17"
                                        @checked($permission->contains('id', 17))>
                                </td>
                                <td></td>
                                <td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="43"
                                        @checked($permission->contains('id', 43))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>All Leaves Requests</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="46"
                                        @checked($permission->contains('id', 46))>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Leave Quota</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="18"
                                        @checked($permission->contains('id', 18))>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Holiday</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="19"
                                        @checked($permission->contains('id', 19))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="20"
                                        @checked($permission->contains('id', 20))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="21"
                                        @checked($permission->contains('id', 21))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="22"
                                        @checked($permission->contains('id', 22))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Deduction Setting</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="44"
                                        @checked($permission->contains('id', 44))></td>
                                <td></td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="45"
                                        @checked($permission->contains('id', 45))></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Allowance</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="23"
                                        @checked($permission->contains('id', 23))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="24"
                                        @checked($permission->contains('id', 24))>
                                </td>
                                <td></td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="25"
                                        @checked($permission->contains('id', 25))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Payslip</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="26"
                                        @checked($permission->contains('id', 18))>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Candidate</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="27"
                                        @checked($permission->contains('id', 27))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="28"
                                        @checked($permission->contains('id', 28))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="29"
                                        @checked($permission->contains('id', 29))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="30"
                                        @checked($permission->contains('id', 30))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Interview Scheduled</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="31"
                                        @checked($permission->contains('id', 31))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="32"
                                        @checked($permission->contains('id', 32))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="33"
                                        @checked($permission->contains('id', 33))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="34"
                                        @checked($permission->contains('id', 34))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Notice Board</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="35"
                                        @checked($permission->contains('id', 35))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="36"
                                        @checked($permission->contains('id', 36))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="37"
                                        @checked($permission->contains('id', 37))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="38"
                                        @checked($permission->contains('id', 38))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Settings</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="39"
                                        @checked($permission->contains('id', 39))>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>My Attendance</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="40"
                                        @checked($permission->contains('id', 40))></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>My Payslip</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="41"
                                        @checked($permission->contains('id', 41))></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Leave Request</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="42"
                                        @checked($permission->contains('id', 42))></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Expense</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="47" @checked($permission->contains('id', 47))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="48" @checked($permission->contains('id', 48))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="49" @checked($permission->contains('id', 49))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="50" @checked($permission->contains('id', 50))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Expense Category</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="51" @checked($permission->contains('id', 51))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="52" @checked($permission->contains('id', 52))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="53" @checked($permission->contains('id', 53))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="54" @checked($permission->contains('id', 54))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Assets</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="55" @checked($permission->contains('id', 55))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="56" @checked($permission->contains('id', 56))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="57" @checked($permission->contains('id', 57))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="58" @checked($permission->contains('id', 58))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Finance Report</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="59" @checked($permission->contains('id', 59))>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Meeting</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="60" @checked($permission->contains('id', 60))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="61" @checked($permission->contains('id', 61))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="62" @checked($permission->contains('id', 62))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="63" @checked($permission->contains('id', 63))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Document</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="64" @checked($permission->contains('id', 64))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="65" @checked($permission->contains('id', 65))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="66" @checked($permission->contains('id', 66))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="67" @checked($permission->contains('id', 67))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Tax</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="68" @checked($permission->contains('id', 68))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="69" @checked($permission->contains('id', 69))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="70" @checked($permission->contains('id', 70))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="71" @checked($permission->contains('id', 71))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Ticket</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="72" @checked($permission->contains('id', 72))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="73" @checked($permission->contains('id', 73))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="74" @checked($permission->contains('id', 74))>
                                </td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="75" @checked($permission->contains('id', 75))>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Action Log</td>
                                <td><input name="permissions[]" class="form-check-input" type="checkbox" value="76" @checked($permission->contains('id', 76))>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary waves-effect waves-light" type="submit">update
                        Role</button>
                </div>
            </form>
        </div>
    </div>
@endisset
