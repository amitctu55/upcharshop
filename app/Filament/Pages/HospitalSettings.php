<?php

namespace App\Filament\Pages;

use App\Models\Hospital;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class HospitalSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'Hospital Settings';
    protected static string $view = 'filament.pages.hospital-settings';

    public ?array $data = [];

    public static function canView(): bool
    {
        return auth()->check();
    }

    public function mount(): void
    {
        $hospital = $this->hospital();
        if ($hospital) {
            $this->form->fill($hospital->toArray());
        }
    }

    public function hospital(): ?Hospital
    {
        if (auth()->user()?->hospital) {
            return auth()->user()->hospital;
        }

        $host = request()->getHost();
        $subdomain = (new \App\Http\Middleware\ResolveHospital)->subdomain($host);
        if ($subdomain !== '' && $subdomain !== 'localhost' && $subdomain !== $host) {
            $h = Hospital::where('slug', $subdomain)->orWhere('custom_domain', $host)->first();
            if ($h) {
                return $h;
            }
        }

        return Hospital::where('slug', 'lifeline')->first() ?? Hospital::first();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Hospital Settings Tabs')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('🏥 Identity & Branding')
                        ->icon('heroicon-o-building-office-2')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Hospital / Clinic Official Name')
                                    ->required()
                                    ->placeholder('e.g. LifeLine Medical Center'),
                                Forms\Components\TextInput::make('tagline')
                                    ->label('Brand Tagline or Motto')
                                    ->placeholder('e.g. Compassionate Care, Advanced Medicine'),
                                Forms\Components\ColorPicker::make('primary_color')
                                    ->label('Primary Brand Color')
                                    ->helperText('Theme color used for buttons, links, and accents across your public portal.')
                                    ->default('#0d9488'),
                                Forms\Components\ColorPicker::make('secondary_color')
                                    ->label('Secondary Brand Accent')
                                    ->helperText('Supplementary shade for badges and gradients.')
                                    ->default('#0f172a'),
                                Forms\Components\FileUpload::make('logo')
                                    ->label('Hospital Logo')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('branding')
                                    ->helperText('PNG, SVG or JPEG with transparent background.'),
                                Forms\Components\FileUpload::make('favicon')
                                    ->label('Browser Favicon')
                                    ->image()
                                    ->directory('branding')
                                    ->helperText('Small square icon (32x32 or 64x64).'),
                            ]),
                        ]),

                    Forms\Components\Tabs\Tab::make('📞 Contact & Hours')
                        ->icon('heroicon-o-phone')
                        ->schema([
                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\TextInput::make('phone')
                                    ->label('Reception Phone')
                                    ->tel()
                                    ->placeholder('+91 98765 00000'),
                                Forms\Components\TextInput::make('emergency_phone')
                                    ->label('Emergency Helpline')
                                    ->tel()
                                    ->placeholder('108 or +91 98765 11111'),
                                Forms\Components\TextInput::make('email')
                                    ->label('Contact Email')
                                    ->email()
                                    ->placeholder('info@hospital.com'),
                                Forms\Components\TextInput::make('whatsapp')
                                    ->label('WhatsApp Support Number')
                                    ->placeholder('+91 98765 22222'),
                                Forms\Components\TextInput::make('city')
                                    ->label('City / Location')
                                    ->placeholder('e.g. Mumbai, Maharashtra'),
                            ]),
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\Textarea::make('address')
                                    ->label('Complete Postal Address')
                                    ->rows(3)
                                    ->placeholder('Street, Landmark, City, State, PIN'),
                                Forms\Components\Textarea::make('map_embed')
                                    ->label('Google Maps Embed URL or iframe code')
                                    ->rows(3)
                                    ->placeholder('https://www.google.com/maps/embed?...'),
                            ]),
                            Forms\Components\KeyValue::make('working_hours')
                                ->label('Department Operating Schedule')
                                ->keyLabel('Days / Department')
                                ->valueLabel('Hours')
                                ->helperText('Displayed on the public website contact footer.'),
                        ]),

                    Forms\Components\Tabs\Tab::make('📅 Booking Rules')
                        ->icon('heroicon-o-calendar-days')
                        ->schema([
                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\TextInput::make('appointment_settings.slot_duration')
                                    ->label('Default Slot Duration')
                                    ->numeric()
                                    ->suffix('minutes')
                                    ->default(15)
                                    ->helperText('Consultation duration per patient slot.'),
                                Forms\Components\TextInput::make('appointment_settings.advance_days')
                                    ->label('Advance Booking Window')
                                    ->numeric()
                                    ->suffix('days')
                                    ->default(30)
                                    ->helperText('How far ahead patients can book appointments.'),
                                Forms\Components\Toggle::make('appointment_settings.auto_confirm')
                                    ->label('Auto-Confirm Bookings')
                                    ->helperText('Automatically confirm online appointments upon submission.')
                                    ->default(true),
                            ]),
                        ]),

                    Forms\Components\Tabs\Tab::make('🌐 SEO & Social Media')
                        ->icon('heroicon-o-globe-alt')
                        ->schema([
                            Forms\Components\TextInput::make('seo.title')
                                ->label('Search Engine Meta Title')
                                ->placeholder('e.g. LifeLine Medical Center — Trusted Multi-Specialty Hospital in Mumbai'),
                            Forms\Components\Textarea::make('seo.description')
                                ->label('Search Engine Meta Description')
                                ->rows(2)
                                ->placeholder('Briefly summarize hospital services, expert doctors, 24x7 emergency care...'),
                            Forms\Components\KeyValue::make('social_links')
                                ->label('Social Media Handles')
                                ->keyLabel('Platform (e.g. Facebook, Instagram, LinkedIn)')
                                ->valueLabel('URL'),
                        ]),
                ])
                ->persistTabInQueryString(),
        ])->statePath('data');
    }

    public function save(): void
    {
        $hospital = $this->hospital();
        if (! $hospital) {
            Notification::make()->title('Hospital not found')->danger()->send();
            return;
        }

        $hospital->update($this->form->getState());
        \App\Models\ActivityLog::track('settings.updated');
        Notification::make()
            ->title('Settings Saved Successfully')
            ->body('Hospital settings and branding are updated live across your portal.')
            ->success()
            ->send();
    }
}
