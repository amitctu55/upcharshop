<?php

namespace Tests\Feature;

use App\Exceptions\SlotTakenException;
use App\Filament\Resources\GalleryResource;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\User;
use App\Services\SlotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    private function hospital(string $slug): Hospital
    {
        return Hospital::create(['slug' => $slug, 'name' => ucfirst($slug).' Hospital']);
    }

    private function user(Hospital $h, string $role): User
    {
        $u = User::create([
            'name' => ucfirst($role),
            'email' => $role.'@'.$h->slug.'.test',
            'password' => bcrypt('secret'),
            'hospital_id' => $h->id
        ]);
        $u->assignRole($role);
        return $u;
    }

    public function test_gallery_module_is_admin_only(): void
    {
        $h = $this->hospital('alpha');

        $this->actingAs($this->user($h, 'hospital_admin'));
        $this->assertTrue(GalleryResource::canViewAny());

        $this->actingAs($this->user($h, 'receptionist'));
        $this->assertFalse(GalleryResource::canViewAny());
        $this->get('/admin/galleries')->assertForbidden();

        $this->actingAs($this->user($h, 'content_editor'));
        $this->get('/admin/galleries')->assertForbidden();
    }

    public function test_hospital_admin_cannot_see_other_hospital_data(): void
    {
        $a = $this->hospital('alpha');
        $b = $this->hospital('beta');
        $deptB = Department::create(['hospital_id' => $b->id, 'name' => 'Cardio', 'slug' => 'cardio']);

        $this->actingAs($this->user($a, 'hospital_admin'));
        $this->assertNull(Department::find($deptB->id));   // global scope blocks it
        $this->assertSame(0, Department::count());
    }

    public function test_double_booking_is_blocked(): void
    {
        $h = $this->hospital('alpha');
        $dept = Department::create(['hospital_id' => $h->id, 'name' => 'General', 'slug' => 'general']);
        $doc = Doctor::create(['hospital_id' => $h->id, 'department_id' => $dept->id, 'name' => 'Dr. Test', 'slug' => 'dr-test']);
        $doc->schedules()->create(['day_of_week' => now()->addDay()->dayOfWeek, 'start_time' => '09:00', 'end_time' => '12:00']);

        app()->instance('current.hospital', $h);
        $date = now()->addDay()->toDateString();
        $service = app(SlotService::class);

        $service->book($doc, $date, '09:00', ['name' => 'P1', 'phone' => '111']);

        $this->expectException(SlotTakenException::class);
        $service->book($doc, $date, '09:00', ['name' => 'P2', 'phone' => '222']);
    }

    public function test_super_admin_sees_all_hospitals(): void
    {
        $this->hospital('alpha');
        $this->hospital('beta');
        $super = User::create(['name' => 'Super', 'email' => 's@test.com', 'password' => bcrypt('secret')]);
        $super->assignRole('super_admin');

        $this->actingAs($super);
        $this->assertSame(2, Hospital::count());
        $this->get('/admin/hospitals')->assertOk();
    }
}
