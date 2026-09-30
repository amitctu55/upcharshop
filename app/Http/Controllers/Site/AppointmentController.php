<?php

namespace App\Http\Controllers\Site;

use App\Exceptions\SlotTakenException;
use App\Http\Controllers\Controller;
use App\Mail\AppointmentBooked;
use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Services\SlotService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function create()
    {
        $departments = Department::where('status', true)
            ->with(['doctors' => fn ($q) => $q->where('status', true)])
            ->orderBy('sort_order')->get();

        $departmentsJson = $departments->map(fn ($d) => [
            'id' => $d->id,
            'name' => $d->name,
            'doctors' => $d->doctors->map(fn ($doc) => [
                'id' => $doc->id,
                'name' => $doc->name,
                'specialization' => $doc->specialization,
            ]),
        ]);

        return view('site.appointment.create', [
            'departments'     => $departments,
            'departmentsJson' => $departmentsJson,
            'advanceDays'     => app('current.hospital')->setting('advance_days', 30),
        ]);
    }

    public function slots(Doctor $doctor, string $date)
    {
        return response()->json(app(SlotService::class)->availableSlots($doctor, Carbon::parse($date)));
    }

    public function store(Request $request, SlotService $slots)
    {
        $data = $request->validate([
            'doctor_id'  => 'required|exists:doctors,id',
            'date'       => 'required|date|after_or_equal:today',
            'time'       => 'required',
            'name'       => 'required|string|max:100',
            'phone'      => 'required|string|max:30',
            'email'      => 'nullable|email',
            'age'        => 'nullable|integer|min:0|max:130',
            'gender'     => 'nullable|in:male,female,other',
            'visit_type' => 'nullable|in:new,followup,video',
            'notes'      => 'nullable|string|max:1000',
        ]);

        $doctor = Doctor::findOrFail($data['doctor_id']);

        if (! in_array($data['time'], $slots->availableSlots($doctor, Carbon::parse($data['date'])))) {
            return back()->withInput()->withErrors(['time' => 'That slot is no longer available. Please choose another.']);
        }

        try {
            $appointment = $slots->book($doctor, $data['date'], $data['time'], $data);
        } catch (SlotTakenException $e) {
            return back()->withInput()->withErrors(['time' => $e->getMessage()]);
        }

        ActivityLog::track('appointment.booked', $appointment);

        if ($appointment->email) {
            Mail::to($appointment->email)->queue(new AppointmentBooked($appointment));
        }
        if ($doctor->hospital->email) {
            Mail::to($doctor->hospital->email)->queue(new AppointmentBooked($appointment));
        }

        return redirect()->route('site.book.success', $appointment->reference_code);
    }

    public function success(string $reference)
    {
        $appointment = Appointment::where('reference_code', $reference)->with('doctor')->firstOrFail();

        return view('site.appointment.success', ['appointment' => $appointment]);
    }
}
