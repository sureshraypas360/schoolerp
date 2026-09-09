<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\School;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::with('publisher')->latest('publish_date')->paginate(15);

        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        $schools = School::orderBy('name')->get();

        return view('admin.notices.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'publish_date' => ['required', 'date'],
        ]);

        $data['published_by'] = $request->user()->id;

        Notice::create($data);

        return redirect()->route('admin.notices.index')->with('status', 'নোটিশ প্রকাশ করা হয়েছে।');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();

        return back()->with('status', 'নোটিশ মুছে ফেলা হয়েছে।');
    }
}
