<?php

use App\Http\Controllers\Site\AppointmentController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\DepartmentController;
use App\Http\Controllers\Site\DoctorController;
use App\Http\Controllers\Site\GalleryController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\PageController;
use App\Http\Controllers\Site\PostController;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $host = $request->getHost();
    $subdomain = (new \App\Http\Middleware\ResolveHospital)->subdomain($host);

    $hospital = Hospital::where('custom_domain', $host)
        ->when($subdomain !== '' && $subdomain !== $host, fn ($q) => $q->orWhere('slug', $subdomain))
        ->first();

    if ($hospital) {
        if ($hospital->status !== 'active') {
            return response()->view('site.maintenance', ['hospital' => $hospital], 503);
        }
        app()->instance('current.hospital', $hospital);
        view()->share('hospital', $hospital);

        return app(HomeController::class)->index();
    }

    $hospitals = Hospital::where('status', 'active')
        ->orderBy('name')
        ->get();

    return view('platform.landing', compact('hospitals'));
})->name('site.home');

Route::post('/platform/book-design', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'template_name' => 'required|string',
        'hospital_name' => 'required|string',
        'contact_name'  => 'required|string',
        'phone'         => 'required|string',
        'email'         => 'nullable|email',
        'city'          => 'nullable|string',
        'subdomain'     => 'nullable|string',
        'notes'         => 'nullable|string',
    ]);

    \App\Models\ActivityLog::track('b2b.template_booked', null, $data);
    $ref = 'UPCHAR-' . strtoupper(substr(md5(uniqid()), 0, 6));

    return response()->json([
        'success'   => true,
        'reference' => $ref,
        'message'   => 'Success! Our onboarding team will reach out shortly to customize and launch your portal.',
    ]);
});

Route::middleware('hospital')->group(function () {
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::get('/departments/{slug}', [DepartmentController::class, 'show']);
    Route::get('/doctors', [DoctorController::class, 'index']);
    Route::get('/doctors/{slug}', [DoctorController::class, 'show']);
    Route::get('/gallery', [GalleryController::class, 'index']);
    Route::get('/news', [PostController::class, 'index']);
    Route::get('/news/{slug}', [PostController::class, 'show']);
    Route::get('/contact', [ContactController::class, 'create']);
    Route::post('/contact', [ContactController::class, 'store']);
    Route::get('/page/{slug}', [PageController::class, 'show']);

    Route::get('/appointment', [AppointmentController::class, 'create'])->name('site.book');
    Route::get('/appointment/slots/{doctor}/{date}', [AppointmentController::class, 'slots']);
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('site.book.store');
    Route::get('/appointment/success/{reference}', [AppointmentController::class, 'success'])->name('site.book.success');
});
