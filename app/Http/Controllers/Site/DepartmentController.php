<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('site.departments.index', [
            'departments' => Department::where('status', true)->withCount('doctors')->orderBy('sort_order')->get(),
        ]);
    }

    public function show(string $slug)
    {
        $department = Department::where('slug', $slug)->where('status', true)->firstOrFail();

        return view('site.departments.show', [
            'department' => $department,
            'doctors'    => $department->doctors()->where('status', true)->get(),
        ]);
    }
}
