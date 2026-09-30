<?php

namespace App\Services;

use App\Exceptions\SlotTakenException;
use App\Models\Appointment;
use App\Models\BlockedDate;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SlotService
{
    /** Free slots for a doctor on a given date */
    public function availableSlots(Doctor $doctor, Carbon $date): array
    {
        if ($date->isPast() && ! $date->isToday()) {
            return [];
        }

        if ($this->isBlocked($doctor, $date)) {
            return [];
        }

        $schedules = $doctor->schedules()
            ->where('day_of_week', $date->dayOfWeek)
            ->where('is_active', true)
            ->get();

        if ($schedules->isEmpty()) {
            return [];
        }

        $default = (int) ($doctor->hospital?->setting('slot_duration', 15) ?? 15);
        $taken = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->pluck('slot_time')
            ->map(fn ($t) => substr($t, 0, 5))
            ->all();

        $slots = [];
        $now = Carbon::now($doctor->hospital?->timezone ?? 'Asia/Kolkata');

        foreach ($schedules as $s) {
            $len = (int) ($s->slot_duration_override ?: $default);
            $cursor = Carbon::parse($date->toDateString().' '.$s->start_time);
            $end = Carbon::parse($date->toDateString().' '.$s->end_time);

            while ($cursor->copy()->addMinutes($len) <= $end) {
                $label = $cursor->format('H:i');
                // Slot is valid if not taken and in future (if today)
                $isFutureSlot = ! $date->isToday() || $cursor->greaterThan($now);

                if (! in_array($label, $taken) && $isFutureSlot) {
                    $slots[] = $label;
                }
                $cursor->addMinutes($len);
            }
        }

        return array_values(array_unique($slots));
    }

    public function isBlocked(Doctor $doctor, Carbon $date): bool
    {
        return BlockedDate::whereDate('date', $date)
            ->where(function ($q) use ($doctor) {
                $q->where('doctor_id', $doctor->id)->orWhereNull('doctor_id');
            })
            ->exists();
    }

    /** Atomic booking — second simultaneous click fails safely with lockForUpdate */
    public function book(Doctor $doctor, string $date, string $time, array $data): Appointment
    {
        return DB::transaction(function () use ($doctor, $date, $time, $data) {
            $clash = Appointment::where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', $date)
                ->whereTime('slot_time', $time)
                ->whereNotIn('status', ['cancelled'])
                ->lockForUpdate()
                ->exists();

            if ($clash) {
                throw new SlotTakenException('This slot was just booked. Please pick another.');
            }

            $patient = Patient::firstOrCreate(
                ['hospital_id' => $doctor->hospital_id, 'phone' => $data['phone']],
                [
                    'name' => $data['name'],
                    'email' => $data['email'] ?? null,
                    'gender' => $data['gender'] ?? null,
                    'address' => $data['address'] ?? null,
                ]
            );

            $autoConfirm = $doctor->hospital?->setting('auto_confirm', true) ?? true;

            $tokenCount = Appointment::where('hospital_id', $doctor->hospital_id)
                ->whereDate('appointment_date', $date)
                ->count();

            return Appointment::create([
                'hospital_id'      => $doctor->hospital_id,
                'reference_code'   => 'MED-'.strtoupper(Str::random(5)),
                'patient_id'       => $patient->id,
                'patient_name'     => $data['name'],
                'phone'            => $data['phone'],
                'email'            => $data['email'] ?? null,
                'age'              => isset($data['age']) ? (int) $data['age'] : null,
                'gender'           => $data['gender'] ?? null,
                'department_id'    => $doctor->department_id,
                'doctor_id'        => $doctor->id,
                'appointment_date' => $date,
                'slot_time'        => $time,
                'visit_type'       => $data['visit_type'] ?? 'new',
                'status'           => $autoConfirm ? 'confirmed' : 'pending',
                'notes'            => $data['notes'] ?? null,
                'source'           => $data['source'] ?? 'online',
                'created_by'       => auth()->id(),
                'token_no'         => $tokenCount + 1,
            ]);
        });
    }
}
