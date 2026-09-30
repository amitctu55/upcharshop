<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\Service;
use App\Models\Stat;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $hospital = app('current.hospital');

        return view('site.home', [
            'banners'      => $hospital->banners()->where('status', true)->orderBy('sort_order')->get(),
            'departments'  => $hospital->departments()->where('status', true)->orderBy('sort_order')->get(),
            'doctors'      => Doctor::where('status', true)->where('is_featured', true)->with('department')->get(),
            'services'     => Service::where('status', true)->orderBy('sort_order')->get(),
            'testimonials' => Testimonial::where('status', true)->get(),
            'stats'        => Stat::all(),
            'posts'        => Post::where('status', 'published')->latest('publish_at')->take(3)->get(),
            'galleries'    => Gallery::where('status', true)->orderBy('sort_order')->take(6)->get(),
        ]);
    }
}
