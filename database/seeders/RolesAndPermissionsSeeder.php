<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'manage hospitals', 'manage users', 'manage site settings',
            'manage departments', 'manage doctors', 'manage schedules',
            'manage galleries',   // ← ADMIN-ONLY MODULE
            'manage pages', 'manage posts', 'manage testimonials',
            'manage banners', 'manage faqs', 'manage services', 'manage stats',
            'view appointments', 'create appointments', 'update appointments', 'manage all appointments',
            'manage inquiries', 'view dashboard', 'view reports', 'view activity logs',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web'])
            ->syncPermissions(Permission::all());

        Role::firstOrCreate(['name' => 'hospital_admin', 'guard_name' => 'web'])->syncPermissions([
            'manage users', 'manage site settings',
            'manage departments', 'manage doctors', 'manage schedules',
            'manage galleries',
            'manage pages', 'manage posts', 'manage testimonials',
            'manage banners', 'manage faqs', 'manage services', 'manage stats',
            'view appointments', 'create appointments', 'update appointments',
            'manage all appointments', 'manage inquiries',
            'view dashboard', 'view reports', 'view activity logs',
        ]);

        Role::firstOrCreate(['name' => 'doctor', 'guard_name' => 'web'])
            ->syncPermissions(['view dashboard', 'view appointments', 'update appointments']);

        Role::firstOrCreate(['name' => 'receptionist', 'guard_name' => 'web'])->syncPermissions([
            'view dashboard', 'view appointments', 'create appointments',
            'update appointments', 'manage all appointments', 'manage inquiries',
        ]);

        Role::firstOrCreate(['name' => 'content_editor', 'guard_name' => 'web'])->syncPermissions([
            'manage pages', 'manage posts', 'manage testimonials', 'manage banners', 'manage faqs', 'view dashboard',
        ]);
    }
}
