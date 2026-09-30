<?php

namespace App\Filament\Pages\Auth;

use App\Models\Hospital;
use App\Models\User;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    protected static string $view = 'filament.pages.auth.login';

    public function getHeading(): string | Htmlable
    {
        $hospital = $this->getCurrentHospital();
        if ($hospital) {
            return $hospital->name . ' Admin';
        }

        return 'Hospital Management Portal';
    }

    public function getSubheading(): string | Htmlable | null
    {
        $hospital = $this->getCurrentHospital();
        if ($hospital) {
            return "Sign in to manage {$hospital->name}";
        }

        return 'Sign in to access your administrative dashboard';
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Email or Username')
            ->placeholder('admin@lifeline.com or admin')
            ->required()
            ->autocomplete('username')
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $login = trim($data['email']);
        $currentHospital = $this->getCurrentHospital();

        // 1. Direct email provided
        if (str_contains($login, '@')) {
            return [
                'email' => strtolower($login),
                'password' => $data['password'],
            ];
        }

        $lowerLogin = strtolower($login);

        // 2. Shortcut for Platform Super Admin
        if (in_array($lowerLogin, ['super', 'superadmin', 'platform'])) {
            return [
                'email' => 'super@platform.com',
                'password' => $data['password'],
            ];
        }

        // 3. Shortcut for tenant usernames (admin, front, editor, doctor1..10)
        if ($currentHospital) {
            $candidateEmail = $lowerLogin . '@' . $currentHospital->slug . '.com';
            if (User::where('email', $candidateEmail)->exists()) {
                return [
                    'email' => $candidateEmail,
                    'password' => $data['password'],
                ];
            }
        }

        // 4. Match by user display name or phone
        $matchedUser = User::where(function ($q) use ($login) {
            $q->where('name', $login)->orWhere('phone', $login);
        })
        ->when($currentHospital, function ($q) use ($currentHospital) {
            $q->where(function ($sq) use ($currentHospital) {
                $sq->where('hospital_id', $currentHospital->id)->orWhereNull('hospital_id');
            });
        })
        ->first();

        if ($matchedUser) {
            return [
                'email' => $matchedUser->email,
                'password' => $data['password'],
            ];
        }

        // Fallback
        return [
            'email' => $login,
            'password' => $data['password'],
        ];
    }

    public function getCurrentHospital(): ?Hospital
    {
        $host = request()->getHost();
        $subdomain = (new \App\Http\Middleware\ResolveHospital)->subdomain($host);

        if ($subdomain !== '' && $subdomain !== 'localhost' && $subdomain !== $host) {
            return Hospital::where('slug', $subdomain)->orWhere('custom_domain', $host)->first();
        }

        return null;
    }
}
