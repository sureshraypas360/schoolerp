<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Staff;
use App\Http\Controllers\Student;
use App\Http\Controllers\Teacher;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // ===== ADMIN =====
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('schools', Admin\SchoolController::class)->except(['show']);
        Route::resource('classes', Admin\SchoolClassController::class)->except(['show'])->parameters(['classes' => 'class']);
        Route::resource('sections', Admin\SectionController::class)->except(['show']);
        Route::resource('subjects', Admin\SubjectController::class)->except(['show']);
        Route::resource('teachers', Admin\TeacherController::class)->except(['show']);
        Route::resource('students', Admin\StudentController::class)->except(['show']);
        Route::resource('staff', Admin\StaffController::class)->except(['show']);

        Route::get('attendance', [Admin\AttendanceController::class, 'index'])->name('attendance.index');

        Route::get('fees', [Admin\FeeController::class, 'index'])->name('fees.index');
        Route::post('fees/types', [Admin\FeeController::class, 'storeType'])->name('fees.types.store');
        Route::get('fees/invoices/create', [Admin\FeeController::class, 'createInvoice'])->name('fees.invoices.create');
        Route::post('fees/invoices', [Admin\FeeController::class, 'storeInvoice'])->name('fees.invoices.store');
        Route::delete('fees/invoices/{invoice}', [Admin\FeeController::class, 'destroyInvoice'])->name('fees.invoices.destroy');

        Route::get('exams', [Admin\ExamController::class, 'index'])->name('exams.index');
        Route::get('exams/create', [Admin\ExamController::class, 'create'])->name('exams.create');
        Route::post('exams', [Admin\ExamController::class, 'store'])->name('exams.store');
        Route::get('exams/{exam}', [Admin\ExamController::class, 'show'])->name('exams.show');
        Route::post('exams/{exam}/subjects', [Admin\ExamController::class, 'addSubject'])->name('exams.subjects.store');
        Route::delete('exams/{exam}', [Admin\ExamController::class, 'destroy'])->name('exams.destroy');

        Route::get('notices', [Admin\NoticeController::class, 'index'])->name('notices.index');
        Route::post('notices', [Admin\NoticeController::class, 'store'])->name('notices.store');
        Route::delete('notices/{notice}', [Admin\NoticeController::class, 'destroy'])->name('notices.destroy');

        Route::get('library', [Admin\LibraryController::class, 'index'])->name('library.index');
        Route::post('library/books', [Admin\LibraryController::class, 'storeBook'])->name('library.books.store');
        Route::post('library/issue', [Admin\LibraryController::class, 'issue'])->name('library.issue');
        Route::post('library/issues/{issue}/return', [Admin\LibraryController::class, 'returnBook'])->name('library.return');

        Route::get('hostel', [Admin\HostelController::class, 'index'])->name('hostel.index');
        Route::post('hostel/rooms', [Admin\HostelController::class, 'storeRoom'])->name('hostel.rooms.store');
        Route::post('hostel/allocate', [Admin\HostelController::class, 'allocate'])->name('hostel.allocate');
        Route::post('hostel/allocations/{allocation}/vacate', [Admin\HostelController::class, 'vacate'])->name('hostel.vacate');

        Route::get('transport', [Admin\TransportController::class, 'index'])->name('transport.index');
        Route::post('transport/routes', [Admin\TransportController::class, 'storeRoute'])->name('transport.routes.store');
        Route::post('transport/assign', [Admin\TransportController::class, 'assign'])->name('transport.assign');
        Route::delete('transport/assignments/{assignment}', [Admin\TransportController::class, 'unassign'])->name('transport.unassign');

        Route::get('idcards', [Admin\IdCardController::class, 'index'])->name('idcards.index');
    });

    // ===== TEACHER =====
    Route::prefix('teacher')->name('teacher.')->middleware('role:teacher')->group(function () {
        Route::get('dashboard', [Teacher\DashboardController::class, 'index'])->name('dashboard');

        Route::get('attendance', [Teacher\AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('attendance', [Teacher\AttendanceController::class, 'store'])->name('attendance.store');

        Route::get('exams', [Teacher\ExamController::class, 'index'])->name('exams.index');
        Route::get('exams/{examSubject}/marks', [Teacher\ExamController::class, 'marks'])->name('exams.marks');
        Route::post('exams/{examSubject}/marks', [Teacher\ExamController::class, 'storeMarks'])->name('exams.marks.store');

        Route::get('homework', [Teacher\HomeworkController::class, 'index'])->name('homework.index');
        Route::post('homework', [Teacher\HomeworkController::class, 'store'])->name('homework.store');
        Route::delete('homework/{homework}', [Teacher\HomeworkController::class, 'destroy'])->name('homework.destroy');
    });

    // ===== STUDENT =====
    Route::prefix('student')->name('student.')->middleware('role:student')->group(function () {
        Route::get('dashboard', [Student\DashboardController::class, 'index'])->name('dashboard');
        Route::get('attendance', [Student\RecordController::class, 'attendance'])->name('attendance');
        Route::get('fees', [Student\RecordController::class, 'fees'])->name('fees');
        Route::get('results', [Student\RecordController::class, 'results'])->name('results');
        Route::get('homework', [Student\HomeworkController::class, 'index'])->name('homework');
        Route::get('facilities', [Student\RecordController::class, 'facilities'])->name('facilities');
    });

    // ===== STAFF =====
    Route::prefix('staff')->name('staff.')->middleware('role:staff')->group(function () {
        Route::get('dashboard', [Staff\DashboardController::class, 'index'])->name('dashboard');
        Route::get('fees', [Staff\FeeCollectionController::class, 'index'])->name('fees.index');
        Route::post('fees/{invoice}/collect', [Staff\FeeCollectionController::class, 'collect'])->name('fees.collect');
    });
});
