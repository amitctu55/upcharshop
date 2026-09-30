<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        return view('site.gallery.index', [
            'categories' => GalleryCategory::all(),
            'active'     => $request->category,
            'items' => Gallery::where('status', true)
                ->when($request->category, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $request->category)))
                ->orderBy('sort_order')->get(),
        ]);
    }
}
