<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $guarded = [];

    protected $casts = [
        'working_hours'         => 'array',
        'social_links'          => 'array',
        'hero_settings'         => 'array',
        'appointment_settings'  => 'array',
        'notification_settings' => 'array',
        'seo'                   => 'array',
    ];

    public function departments() { return $this->hasMany(Department::class); }
    public function doctors()     { return $this->hasMany(Doctor::class); }
    public function users()       { return $this->hasMany(User::class); }
    public function galleries()   { return $this->hasMany(Gallery::class); }
    public function pages()       { return $this->hasMany(Page::class); }
    public function banners()     { return $this->hasMany(Banner::class); }
    public function services()    { return $this->hasMany(Service::class); }
    public function faqs()        { return $this->hasMany(Faq::class); }
    public function testimonials(){ return $this->hasMany(Testimonial::class); }
    public function posts()       { return $this->hasMany(Post::class); }
    public function appointments(){ return $this->hasMany(Appointment::class); }
    public function patients()    { return $this->hasMany(Patient::class); }

    /** Convenience: $hospital->setting('auto_confirm', false) */
    public function setting(string $key, mixed $default = null): mixed
    {
        return $this->appointment_settings[$key] ?? $default;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
