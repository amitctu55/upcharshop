<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\GalleryCategory;
use App\Models\Hospital;
use App\Models\Page;
use App\Models\Service;
use App\Models\Stat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $super = User::firstOrCreate(
            ['email' => 'super@platform.com'],
            ['name' => 'Platform Owner', 'password' => Hash::make('ChangeMe!123')]
        );
        $super->assignRole('super_admin');

        foreach ([
            ['slug' => 'democare', 'name' => 'DemoCare Hospital',       'primary_color' => '#0E7C6B'],
            ['slug' => 'lifeline', 'name' => 'LifeLine Medical Center', 'primary_color' => '#2456E6'],
        ] as $data) {
            $hospital = Hospital::firstOrCreate(['slug' => $data['slug']], $data + [
                'tagline' => 'Caring for life',
                'phone' => '+91 98765 00000', 'emergency_phone' => '108',
                'email' => $data['slug'].'@demo.com',
                'address' => '12 Health Street', 'city' => 'Mumbai',
                'working_hours' => ['Mon – Sat' => '9:00 AM – 8:00 PM', 'Emergency' => '24 × 7'],
                'appointment_settings' => ['slot_duration' => 15, 'auto_confirm' => true, 'advance_days' => 30],
                'seo' => ['title' => $data['name'], 'description' => 'Multi-speciality hospital'],
            ]);

            // Staff
            foreach ([['admin@', 'hospital_admin'], ['front@', 'receptionist'], ['editor@', 'content_editor']] as [$prefix, $role]) {
                User::firstOrCreate(
                    ['email' => $prefix.$data['slug'].'.com'],
                    ['name' => ucfirst(explode('_', $role)[0]), 'password' => Hash::make('password'), 'hospital_id' => $hospital->id]
                )->syncRoles([$role]);
            }

            // Departments
            $depts = collect(['Cardiology', 'Neurology', 'Orthopedics', 'Pediatrics', 'Gynecology', 'General Medicine'])
                ->map(fn ($name, $i) => Department::create([
                    'hospital_id' => $hospital->id, 'name' => $name,
                    'short_description' => "Expert $name care with modern equipment.",
                    'services' => [['name' => $name.' OPD'], ['name' => $name.' Diagnostics']],
                    'is_featured' => $i < 3, 'sort_order' => $i,
                ]));

            // Doctors + schedules + doctor logins
            foreach (range(1, 10) as $i) {
                $doc = Doctor::create([
                    'hospital_id' => $hospital->id,
                    'department_id' => $depts[($i - 1) % 6]->id,
                    'name' => 'Dr. '.fake()->name(),
                    'designation' => 'Consultant', 'qualifications' => 'MBBS, MD',
                    'consultation_fee' => 500, 'is_featured' => $i <= 4,
                ]);
                foreach ([1, 2, 3, 4, 5, 6] as $day) {
                    DoctorSchedule::create([
                        'doctor_id' => $doc->id, 'day_of_week' => $day,
                        'start_time' => '09:00', 'end_time' => '17:00',
                    ]);
                }
                User::create([
                    'email' => 'doctor'.$i.'@'.$data['slug'].'.com',
                    'name' => $doc->name, 'password' => Hash::make('password'),
                    'hospital_id' => $hospital->id, 'doctor_id' => $doc->id,
                ])->assignRole('doctor');
            }

            // Content
            foreach ([['About Us', 'about', true], ['Privacy Policy', 'privacy', false], ['Terms of Service', 'terms', false]] as [$t, $s, $menu]) {
                Page::create(['hospital_id' => $hospital->id, 'title' => $t, 'slug' => $s,
                    'body' => "<p>$t content — edit from the admin panel.</p>", 'show_in_menu' => $menu]);
            }
            foreach (['Infrastructure', 'Our Team', 'Events', 'Awards'] as $c) {
                GalleryCategory::create(['hospital_id' => $hospital->id, 'name' => $c]);
            }
            foreach ([['24×7 Emergency', '🚑'], ['Pharmacy', '💊'], ['ICU', '🛏'], ['Laboratory', '🔬'], ['Ambulance', '🚐']] as $i => [$n, $icon]) {
                Service::create(['hospital_id' => $hospital->id, 'name' => $n, 'icon' => $icon, 'sort_order' => $i]);
            }
            foreach ([['Years of Care', '15+'], ['Specialist Doctors', '10+'], ['Happy Patients', '25,000+'], ['Beds', '120']] as [$l, $v]) {
                Stat::create(['hospital_id' => $hospital->id, 'label' => $l, 'value' => $v]);
            }
        }
    }
}
