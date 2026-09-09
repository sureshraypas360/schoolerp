<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookIssue;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        $books = Book::with('school')->latest()->get();
        $issues = BookIssue::with(['book', 'student.user'])->where('status', 'issued')->latest()->get();
        $students = Student::with('user')->orderBy('admission_no')->get();
        $schools = School::orderBy('name')->get();

        return view('admin.library.index', compact('books', 'issues', 'students', 'schools'));
    }

    public function storeBook(Request $request)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:50'],
            'total_copies' => ['required', 'integer', 'min:1'],
        ]);

        $data['available_copies'] = $data['total_copies'];

        Book::create($data);

        return back()->with('status', 'বই যোগ করা হয়েছে।');
    }

    public function issue(Request $request)
    {
        $data = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'student_id' => ['required', 'exists:students,id'],
            'due_date' => ['nullable', 'date'],
        ]);

        $book = Book::findOrFail($data['book_id']);

        if ($book->available_copies < 1) {
            return back()->with('status', 'কোনো কপি উপলব্ধ নেই।');
        }

        BookIssue::create([
            'book_id' => $book->id,
            'student_id' => $data['student_id'],
            'issue_date' => now(),
            'due_date' => $data['due_date'] ?? now()->addDays(14),
            'status' => 'issued',
        ]);

        $book->decrement('available_copies');

        return back()->with('status', 'বই ইস্যু করা হয়েছে।');
    }

    public function returnBook(BookIssue $issue)
    {
        $issue->update(['status' => 'returned', 'return_date' => now()]);
        $issue->book()->increment('available_copies');

        return back()->with('status', 'বই ফেরত নেওয়া হয়েছে।');
    }
}
