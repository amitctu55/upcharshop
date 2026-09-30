<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = ['hospital_id', 'doctor_id', 'name', 'email', 'password', 'phone', 'avatar', 'is_active', 'last_login_at'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['password' => 'hashed', 'is_active' => 'boolean', 'last_login_at' => 'datetime'];

    public function hospital() { return $this->belongsTo(Hospital::class); }
    public function doctorProfile() { return $this->belongsTo(Doctor::class, 'doctor_id'); }
    public function canAccessPanel(Panel $panel): bool { return $this->is_active ?? true; }
    public function isSuperAdmin(): bool { return $this->hasRole('super_admin'); }
}
