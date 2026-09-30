<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(\App\Filament\Pages\Auth\Login::class)
            ->colors([
                'primary' => Color::Teal,
            ])
            ->brandName(function () {
                $host = request()->getHost();
                $subdomain = (new \App\Http\Middleware\ResolveHospital)->subdomain($host);
                if ($subdomain !== '' && $subdomain !== 'localhost' && $subdomain !== $host) {
                    $hospital = \App\Models\Hospital::where('slug', $subdomain)->orWhere('custom_domain', $host)->first();
                    if ($hospital) {
                        return $hospital->name;
                    }
                }
                return 'Hospital Platform';
            })
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->widgets([
                \App\Filament\Widgets\HospitalHeroWidget::class,
                \App\Filament\Widgets\AppointmentStats::class,
                \App\Filament\Widgets\AppointmentsChart::class,
                \App\Filament\Widgets\DepartmentDistributionChart::class,
                \App\Filament\Widgets\HospitalOperationsWidget::class,
                \App\Filament\Widgets\RecentAppointmentsWidget::class,
            ])
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn (): string => \Illuminate\Support\Facades\Blade::render("@include('filament.custom-styles')")
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::TOPBAR_START,
                fn (): string => \Illuminate\Support\Facades\Blade::render("@include('filament.topbar-tenant-badge')")
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
