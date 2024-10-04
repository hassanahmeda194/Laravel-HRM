<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <!-- Dashboard -->
                <li class="menu-title" key="t-apps">Dashboard</li>
                <li class="mb-2">
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="bx bx-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-title" key="t-apps">Modules</li>
                <!-- Employee Management -->
                @can('permission', ['employee_view', 'department_view', 'designation_view'])
                    <li class="mb-2">
                        <a class="waves-effect has-arrow">
                            <i class="bx bx-user"></i>
                            <span>Employees</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('permission', 'employee_view')
                                <li class="mb-2">
                                    <a href="{{ route('employee.index') }}">Employees</a>
                                </li>
                            @endcan
                            @can('permission', 'department_view')
                                <li class="mb-2">
                                    <a href="{{ route('department.index') }}">Units</a>
                                </li>
                            @endcan
                            @can('permission', 'designation_view')
                                <li class="mb-2">
                                    <a href="{{ route('designation.index') }}">Roles</a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcan

                <!-- Leave Management -->
                @can('permission', ['leave_view', 'leave_quota_view', 'holiday_view', 'all_leave_request',
                    'attendance_view'])
                    <li class="mb-2">
                        <a class="waves-effect has-arrow">
                            <i class="bx bx-calendar"></i>
                            <span>Attendace & Leave </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('permission', 'leave_view')
                                <li class="mb-2">
                                    <a href="{{ route('leave.index') }}">Mark Leave</a>
                                </li>
                            @endcan
                            @can('permission', 'leave_quota_view')
                                <li class="mb-2">
                                    <a href="{{ route('leave.quota') }}">Leave Quota</a>
                                </li>
                            @endcan
                            @can('permission', 'holiday_view')
                                <li class="mb-2">
                                    <a href="{{ route('holiday.index') }}">Holiday</a>
                                </li>
                            @endcan
                            @can('permission', 'all_leave_request')
                                <li class="mb-2">
                                    <a href="{{ route('all.leave.request') }}">All Leave Requests</a>
                                </li>
                            @endcan
                            @can('permission', 'attendance_view')
                                <li class="mb-2">
                                    <a href="{{ route('attendance.index') }}">Attendance</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                <!-- Recruitment -->
                @can('permission', ['candidate_view', 'interview_schedule_view'])
                    <li class="mb-2">
                        <a class="waves-effect has-arrow">
                            <i class="bx bx-user"></i>
                            <span>Recruitment</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('permission', 'candidate_view')
                                <li class="mb-2">
                                    <a href="{{ route('candidate.index') }}">Candidates</a>
                                </li>
                            @endcan
                            @can('permission', 'interview_schedule_view')
                                <li class="mb-2">
                                    <a href="{{ route('interview.schedule.index') }}">Interview Schedules</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan


                <!-- Finance -->
                @can('permission', ['expenses_index', 'expenses_category_index', 'assets_index', 'report_index',
                    'allowance_view', 'payslip_view'])
                    <li class="mb-2">
                        <a class="waves-effect has-arrow">
                            <i class="bx bx-dollar"></i>
                            <span>Finance</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('permission', 'allowance_view')
                                <li class="mb-2">
                                    <a href="{{ route('allowance.index') }}">Allowance</a>
                                </li>
                            @endcan
                            @can('permission', 'payslip_view')
                                <li class="mb-2">
                                    <a href="{{ route('payslip.index') }}">PaySlip</a>
                                </li>
                            @endcan
                            @can('permission', 'expenses_index')
                                <li class="mb-2">
                                    <a href="{{ route('expenses.index') }}">Expenses</a>
                                </li>
                            @endcan
                            @can('permission', 'expenses_category_index')
                                <li class="mb-2">
                                    <a href="{{ route('expense-categories.index') }}">Expense Categories</a>
                                </li>
                            @endcan
                            @can('permission', 'assets_index')
                                <li class="mb-2">
                                    <a href="{{ route('asset-management.index') }}">Assets</a>
                                </li>
                            @endcan
                            @can('permission', 'report_index')
                                <li class="mb-2">
                                    <a href="{{ route('finance.index') }}">Reports</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                <!-- Administration -->
                @can('permission', ['meeting_index', 'document_index', 'tax_index', 'notice_board_view'])
                    <li class="mb-2">
                        <a class="waves-effect has-arrow">
                            <i class="bx bx-calendar"></i>
                            <span>Administration</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('permission', 'meeting_index')
                                <li class="mb-2">
                                    <a href="{{ route('meetings.index') }}">Meetings</a>
                                </li>
                            @endcan
                            @can('permission', 'document_index')
                                <li class="mb-2">
                                    <a href="{{ route('document.index') }}">Documents</a>
                                </li>
                            @endcan
                            @can('permission', 'tax_index')
                                <li class="mb-2">
                                    <a href="{{ route('tax.index') }}">Taxes</a>
                                </li>
                            @endcan
                            @can('permission', 'notice_board_view')
                                <li class="mb-2">
                                    <a href="{{ route('notice.board.index') }}">Notice Board</a>
                                </li>
                            @endcan
                            @can('permission', 'ticket_index')
                                <li class="mb-2">
                                    <a href="{{ route('tickets.index') }}">Ticket</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                <!-- Support -->

                @can('permission', 'setting')
                    <li class="mb-2">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-cog"></i>
                            <span key="t-projects">Configrations</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="mb-2"><a href="projects-grid.html" key="t-p-grid">Website Settings</a>
                            </li>
                            @can('permission', 'deduction_setting_view')
                                <li class="mb-2"><a href="{{ route('deduction.index') }}" key="t-p-overview">Deduction
                                        Settings</a></li>
                            @endcan
                            @can('permission', 'deduction_setting_view')
                                <li class="mb-2"><a href="{{ route('action.log') }}" key="t-p-overview">Action Logs</a></li>
                            @endcan
                        </ul>
                    </li>
                    <!-- Sub-Menu Format -->


                @endcan
                @can('permission', ['MyAttendance', 'LeaveRequest', 'MyPayslip'])
                    <li class="mb-2">
                        <a class="waves-effect has-arrow">
                            <i class="bx bx-user"></i>
                            <span key="t-personal">Personal</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('permission', 'MyAttendance')
                                <li class="mb-2">
                                    <a href="{{ route('my.attendance') }}" key="t-my-attendance">My Attendance</a>
                                </li>
                            @endcan
                            @can('permission', 'LeaveRequest')
                                <li class="mb-2">
                                    <a href="{{ route('leave.request.index') }}" key="t-leave-request">Leave Request</a>
                                </li>
                            @endcan
                            @can('permission', 'MyPayslip')
                                <li class="mb-2">
                                    <a href="{{ route('my.payslip') }}" key="t-my-payslip">My Payslip</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                <li class="mb-2">
                    <a class="waves-effect has-arrow">
                        <i class="bx bx-file"></i> <!-- Icon for Invoice -->
                        <span key="t-personal">Invoice</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="mb-2">
                            <a href="{{ route('customer.index') }}" key="t-clients">
                                Customers
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('branch.index') }}" key="t-branch">
                                Branch
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" key="t-invoice">
                                Invoice
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" key="t-payment">
                                Payments
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
