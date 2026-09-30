<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view appointments');
    }

    public function view(User $user, Appointment $appointment): bool
    {
        if ($user->hasRole('doctor')) {
            // Doctors can only view appointments for their doctor profile
            return $appointment->doctor_id && $user->email === 'doctor'.($appointment->doctor_id).'@'.($appointment->hospital->slug ?? '').'.com'
                || $user->can('manage all appointments');
        }

        return $user->can('view appointments');
    }

    public function create(User $user): bool
    {
        return $user->can('create appointments') || $user->can('manage all appointments');
    }

    public function update(User $user, Appointment $appointment): bool
    {
        return $user->can('update appointments') || $user->can('manage all appointments');
    }

    public function delete(User $user, Appointment $appointment): bool
    {
        return $user->can('manage all appointments');
    }
}
