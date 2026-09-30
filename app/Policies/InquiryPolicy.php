<?php

namespace App\Policies;

use App\Models\Inquiry;
use App\Models\User;

class InquiryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage inquiries');
    }

    public function view(User $user, Inquiry $inquiry): bool
    {
        return $user->can('manage inquiries');
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Inquiry $inquiry): bool
    {
        return $user->can('manage inquiries');
    }

    public function delete(User $user, Inquiry $inquiry): bool
    {
        return $user->hasAnyRole(['super_admin', 'hospital_admin']);
    }
}
