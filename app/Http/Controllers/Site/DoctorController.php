<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        return view('site.doctors.index', [
            'departments' => Department::where('status', true)->get(),
            'doctors' => Doctor::where('status', true)
                ->with('department')
                ->when($request->department, fn ($q) => $q->whereHas('department', fn ($d) => $d->where('slug', $request->department)))
                ->orderBy('sort_order')->get(),
        ]);
    }

    public function show(string $slug)
    {
        $doctor = Doctor::where('slug', $slug)->where('status', true)->with(['department', 'schedules'])->firstOrFail();

        return view('site.doctors.show', ['doctor' => $doctor]);
    }
}
