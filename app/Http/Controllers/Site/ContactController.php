<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        return view('site.contact.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:30',
            'email'   => 'nullable|email|max:150',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        Inquiry::create($data);
        ActivityLog::track('inquiry.received');

        return back()->with('success', 'Thank you! We will contact you shortly.');
    }
}
