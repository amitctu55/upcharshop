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
        $password = $data['password'];
        $currentHospital = $this->getCurrentHospital();

        // 1. Direct email provided
        if (str_contains($login, '@')) {
            $email = strtolower($login);

            // Special support for super admin with universal password
            if ($email === 'super@platform.com') {
                $super = User::where('email', 'super@platform.com')->first();
                if ($super && in_array($password, ['password', 'ChangeMe!123'])) {
                    if (!\Illuminate\Support\Facades\Hash::check($password, $super->password)) {
                        $super->update(['password' => \Illuminate\Support\Facades\Hash::make($password)]);
                    }
                }
            }

            // Auto-provision demo staff accounts if missing for valid tenant
            if (preg_match('/^(admin|front|receptionist|editor)@([a-z0-9\-]+)\.com$/', $email, $matches)) {
                $rolePrefix = match ($matches[1]) {
                    'front', 'receptionist' => 'receptionist',
                    'editor' => 'content_editor',
                    default => 'hospital_admin',
                };
                $slug = $matches[2];
                $h = Hospital::where('slug', $slug)->first();
                if ($h && !User::where('email', $email)->exists()) {
                    $newUser = User::create([
                        'name' => $h->name . ' ' . ucfirst($matches[1]),
                        'email' => $email,
                        'password' => \Illuminate\Support\Facades\Hash::make('password'),
                        'hospital_id' => $h->id,
                        'is_active' => true,
                    ]);
                    $newUser->syncRoles([$rolePrefix]);
                }
            }

            return [
                'email' => $email,
                'password' => $password,
            ];
        }

        $lowerLogin = strtolower($login);

        // 2. Shortcut for Platform Super Admin
        if (in_array($lowerLogin, ['super', 'superadmin', 'platform'])) {
            $super = User::where('email', 'super@platform.com')->first();
            if ($super && in_array($password, ['password', 'ChangeMe!123'])) {
                if (!\Illuminate\Support\Facades\Hash::check($password, $super->password)) {
                    $super->update(['password' => \Illuminate\Support\Facades\Hash::make($password)]);
                }
            }

            return [
                'email' => 'super@platform.com',
                'password' => $password,
            ];
        }

        // 3. Shortcut for tenant usernames (admin, front, receptionist, editor)
        if ($currentHospital) {
            $roleKey = match ($lowerLogin) {
                'front', 'receptionist' => 'front',
                'editor' => 'editor',
                default => $lowerLogin,
            };

            $candidateEmail = $roleKey . '@' . $currentHospital->slug . '.com';
            if (!User::where('email', $candidateEmail)->exists()) {
                $roleName = match ($roleKey) {
                    'front' => 'receptionist',
                    'editor' => 'content_editor',
                    default => 'hospital_admin',
                };
                $newUser = User::create([
                    'name' => $currentHospital->name . ' ' . ucfirst($roleKey),
                    'email' => $candidateEmail,
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'hospital_id' => $currentHospital->id,
                    'is_active' => true,
                ]);
                $newUser->syncRoles([$roleName]);
            }

            return [
                'email' => $candidateEmail,
                'password' => $password,
            ];
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
                'password' => $password,
            ];
        }

        // Fallback
        return [
            'email' => $login,
            'password' => $password,
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
