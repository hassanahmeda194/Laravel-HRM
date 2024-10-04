<?php

use App\Helpers\CustomHelper;
use App\Http\Controllers\AllowanceController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgetPassword;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FinanceReportController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\InterviewScheduleController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveQuotaController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Models\ActionLog;
use App\Models\Attendance;
use App\Models\Designation;
use App\Models\ExpenseCategory;
use App\Models\InterviewSchedule;
use App\Services\AttendanceService;
use App\Services\EmployeeService;
use App\Services\ImportService;
use GuzzleHttp\Psr7\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/login');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/submit-login', [AuthController::class, 'Submitlogin'])->name('submit.login');
Route::get('/500', function () {
    return view('errors.500');
});
Route::post('/check-location', [AuthController::class, 'checkLocation']);
Route::get('/forget-password', [ForgetPasswordController::class, 'forgetPassword'])->name('forget.password');
Route::post('/submit-forget-password', [ForgetPasswordController::class, 'SubmitForgetPassword'])->name('submit.forget.password');

Route::get('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset.password');
Route::post('/submit-reset-password', [ResetPasswordController::class, 'SubmitResetPassword'])->name('submit.reset.password');

Route::middleware('check.auth')->group(function () {
    Route::get('/otp-verification', [AuthController::class, 'otpVerification'])->name('otp.verification');
    Route::post('/otp-verification', [AuthController::class, 'submitOtpVerification'])->name('submit.otp.verification');
    Route::get('/again-otp-verification', [AuthController::class, 'againOtpVerification'])->name('again.otp.verification');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::prefix('Employee')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('employee.index');
        Route::get('/create', [UserController::class, 'create'])->name('employee.create');
        Route::post('/store', [UserController::class, 'store'])->name('employee.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('employee.edit')->middleware('check.permission:employee_update');
        Route::post('/Update/{id}', [UserController::class, 'update'])->name('employee.update')->middleware('check.permission:employee_update');
        Route::get('/Delete/{id}', [UserController::class, 'destroy'])->name('employee.delete')->middleware('check.permission:employee_delete');
        Route::get('/delete-document/{id}', [EmployeeService::class, 'delete_document'])->name('delete.document');
        Route::get('/profile/{id}', [EmployeeService::class, 'profile_page'])->name('employee.profile')->middleware('check.permission:employee_detail');
        Route::post('/update-personal-infomation', [EmployeeService::class, 'update_personal_information'])->name('update.personal.information');
        Route::post('/update-password', [EmployeeService::class, 'update_password'])->name('update.password');
        Route::post('/update-bank-details', [EmployeeService::class, 'bank_details'])->name('update.bank.details');
    });

    Route::prefix('Department')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('department.index')->middleware('check.permission:department_view');
        Route::post('/store', [DepartmentController::class, 'store'])->name('department.store');
        Route::get('/edit', [DepartmentController::class, 'edit'])->name('department.edit')->middleware('check.permission:department_update');
        Route::post('/update', [DepartmentController::class, 'update'])->name('department.update');
        Route::get('/delete/{id}', [DepartmentController::class, 'destroy'])->name('department.delete')->middleware('check.permission:department_delete');
    });

    Route::prefix('Designation')->group(function () {
        Route::get('/', [DesignationController::class, 'index'])->name('designation.index')->middleware('check.permission:designation_view');
        Route::post('/store', [DesignationController::class, 'store'])->name('designation.store');
        Route::get('/edit', [DesignationController::class, 'edit'])->name('designation.edit')->middleware('check.permission:designation_update');
        Route::post('/update/{id}', [DesignationController::class, 'update'])->name('designation.update');
        Route::get('/delete/{id}', [DesignationController::class, 'destroy'])->name('designation.delete')->middleware('check.permission:designation_delete');
    });

    Route::prefix('Attendance')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/check-in', [AttendanceService::class, 'CheckIn'])->name('check.in');
        Route::get('/checkOut', [AttendanceService::class, 'CheckOut'])->name('check.out');
        Route::get('/get-attendance-data', [AttendanceController::class, 'show'])->name('get.attendance.data');
        Route::post('/update-attendance', [AttendanceController::class, 'markAttendance'])->name('attendance.update');
    });

    Route::prefix('Leaves')->group(function () {
        Route::get('/', [LeaveController::class, 'index'])->name('leave.index')->middleware('check.permission:leave_view');
        Route::post('/mark-leave', [LeaveController::class, 'store'])->name('leave.store')->middleware('check.permission:leave_create');
        Route::get('/delete-leave/{id}', [LeaveController::class, 'destroy'])->name('delete.leave')->middleware('check.permission:leave_delete');
        Route::get('/leave-quota', [LeaveQuotaController::class, 'index'])->name('leave.quota');
    });

    Route::prefix('Holiday')->group(function () {
        Route::get('/', [HolidayController::class, 'index'])->name('holiday.index')->middleware('check.permission:holiday_view');
        Route::post('/store', [HolidayController::class, 'store'])->name('holiday.store');
        Route::get('/edit', [HolidayController::class, 'edit'])->name('holiday.edit')->middleware('check.permission:holiday_update');
        Route::post('/update', [HolidayController::class, 'update'])->name('holiday.update');
        Route::get('/delete/{id}', [HolidayController::class, 'destroy'])->name('holiday.delete')->middleware('check.permission:holiday_delete');
    });

    Route::prefix('Allowance')->group(function () {
        Route::get('/', [AllowanceController::class, 'index'])->name('allowance.index')->middleware('check.permission:allowance_view');
        Route::post('/store', [AllowanceController::class, 'store'])->name('allowance.store');
        Route::get('/delete/{id}', [AllowanceController::class, 'destroy'])->name('allowance.delete')->middleware('check.permission:allowance_delete');
    });
    Route::prefix('payslip')->group(function () {
        Route::get('/', [PayslipController::class, 'index'])->name('payslip.index')->middleware('check.permission:payslip_view');
        Route::post('/download-payslip', [PayslipController::class, 'downloadPaySlip'])->name('download.payslip.index');
    });
    Route::prefix('Setting')->group(function () {
        Route::get('/setting', function () {
            return "Setting";
        })->middleware('check.permission:setting');
        Route::resource('expense-categories', ExpenseCategoryController::class);
    });

    Route::prefix('Deduction')->group(function () {
        Route::get('/', [DeductionController::class, 'index'])->name('deduction.index')->middleware('check.permission:deduction_setting_view');
        Route::get('/edit', [DeductionController::class, 'edit'])->name('deduction.edit')->middleware('check.permission:deduction_setting_update');
        Route::post('/update', [DeductionController::class, 'update'])->name('deduction.update');
    });

    Route::prefix('Candidate')->group(function () {
        Route::get('/', [CandidateController::class, 'index'])->name('candidate.index')->middleware('check.permission:candidate_view');
        Route::post('/store', [CandidateController::class, 'store'])->name('candidate.store');
        Route::get('/edit', [CandidateController::class, 'edit'])->name('candidate.edit')->middleware('check.permission:candidate_update');
        Route::post('/update/{id}', [CandidateController::class, 'update'])->name('candidate.update');
        Route::get('/delete/{id}', [CandidateController::class, 'destroy'])->name('candidate.delete')->middleware('check.permission:candidate_delete');
    });

    Route::prefix('interview-schedule')->group(function () {
        Route::get('/', [InterviewScheduleController::class, 'index'])->name('interview.schedule.index')->middleware('check.permission:interview_schedule_view');
        Route::post('/store', [InterviewScheduleController::class, 'store'])->name('interview.schedule.store');
        Route::get('/edit', [InterviewScheduleController::class, 'edit'])->name('interview.schedule.edit')->middleware('check.permission:interview_schedule_update');
        Route::post('/update/{id}', [InterviewScheduleController::class, 'update'])->name('interview.schedule.update');
        Route::get('/delete/{id}', [InterviewScheduleController::class, 'destroy'])->name('interview.schedule.destroy')->middleware('check.permission:interview_schedule_delete');
    });
    Route::prefix('Notice-board')->group(function () {
        Route::get('/', [NoticeBoardController::class, 'index'])->name('notice.board.index')->middleware('check.permission:notice_board_view');
        Route::post('/store', [NoticeBoardController::class, 'store'])->name('notice.board.store');
        Route::get('/edit', [NoticeBoardController::class, 'edit'])->name('notice.board.edit')->middleware('check.permission:notice_board_update');
        Route::get('/update', [NoticeBoardController::class, 'update'])->name('notice.board.update');
        Route::get('/delete/{id}', [NoticeBoardController::class, 'destroy'])->name('notice.board.delete')->middleware('check.permission:notice_board_delete');
        Route::get('/get-data', [NoticeBoardController::class, 'getData'])->name('get.notice.board.data');
    });
    Route::get('my-attendance', [AttendanceController::class, 'index'])->name('my.attendance')->middleware('check.permission:MyAttendance');

    Route::get('my-payslip', [PayslipController::class, 'myPayslip'])->name('my.payslip')->middleware('check.permission:MyPayslip');


    Route::prefix('Leave-Request')->group(function () {
        Route::middleware('check.permission:LeaveRequest')->group(function () {
            Route::get('/', [LeaveRequestController::class, 'index'])->name('leave.request.index');
            Route::post('/store', [LeaveRequestController::class, 'store'])->name('leave.request.store');
            Route::get('/edit', [LeaveRequestController::class, 'edit'])->name('leave.request.edit');
            Route::post('/update/{id}', [LeaveRequestController::class, 'update'])->name('leave.request.update');
            Route::get('/delete/{id}', [LeaveRequestController::class, 'destroy'])->name('leave.request.delete');
        });
        Route::middleware('check.permission:all_leave_request')->group(function () {
            Route::get('/All', [LeaveRequestController::class, 'getAllLeaveRequest'])->name('all.leave.request');
            Route::get('/Reject/{id}', [LeaveRequestController::class, 'leaveRequestReject'])->name('leave.request.reject');
            Route::get('/Approve/{id}', [LeaveRequestController::class, 'leaveRequestApprove'])->name('leave.request.approve');
        });
    });

    Route::resource('expenses', ExpenseController::class);
    Route::resource('/asset-management', AssetController::class);
    Route::put('asset-management/{asset}', [AssetController::class, 'update'])->name('asset-management.update');

    Route::resource('/tax', TaxController::class);
    Route::get('fiance-report', [FinanceReportController::class, 'index'])->name('finance.index');
    Route::get('/generate-report', [FinanceReportController::class, "generate_report"])->name("generate.report");

    Route::get('/get-notification', [NotificationController::class, 'getNotification'])->name('get.notification');
    Route::get('/read-notification', [NotificationController::class, 'readNotification'])->name('read.notification');
    Route::view('/action-log', 'action-log.index', ['data' => ActionLog::with('user')->OrderByDesc('id')->get()])->name('action.log');

    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

    Route::get('/get-ticket-data', [TicketController::class, 'show'])->name('get.ticket.data');
    Route::post('/tickets-update/{id}', [TicketController::class, "update"])->name('tickets.update');
    Route::post('/update-ticket-status}', [TicketController::class, "updateStatus"])->name('update.tickets.status');


    Route::prefix('meetings')->group(function () {
        Route::get('/', [MeetingController::class, 'index'])->name('meetings.index');
        Route::post('/', [MeetingController::class, 'store'])->name('meetings.store');
        Route::get('/edit', [MeetingController::class, 'edit'])->name('meetings.edit');
        Route::put('/update/{id}', [MeetingController::class, 'update'])->name('meetings.update');
        Route::get('/delete/{id}', [MeetingController::class, 'destroy'])->name('meetings.destroy');
    });

    Route::prefix('document')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('document.index');
        Route::post('/', [DocumentController::class, 'store'])->name('document.store');
        Route::get('/edit', [DocumentController::class, 'edit'])->name('document.edit');
        Route::put('/update/{id}', [DocumentController::class, 'update'])->name('document.update');
        Route::delete('/delete/{id}', [DocumentController::class, 'destroy'])->name('document.destroy');
    });

    Route::prefix('import')->group(function () {
        Route::post('/import-employee', [ImportService::class, 'importEmployee'])->name('import.employee');
        Route::post('/import-department', [ImportService::class, 'importDepartments'])->name('import.department');
        Route::post('/import-designation', [ImportService::class, 'importDesignation'])->name('import.designation');
        Route::post('/import-candidate', [ImportService::class, 'importCandidate'])->name('import.candidate');
        Route::post('/import-allowance', [ImportService::class, 'importAllowance'])->name('import.allowance');
    });


    Route::prefix('crm')->group(function () {
        Route::resource('customer', CustomerController::class);
        Route::resource('branch', BranchController::class);
        Route::resource('invoice', InvoiceController::class);
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
