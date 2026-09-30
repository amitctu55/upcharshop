<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentBooked extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Appointment $appointment) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Appointment '.$this->appointment->reference_code.' — '.$this->appointment->hospital->name);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.appointment', with: [
            'appointment' => $this->appointment,
            'hospital'    => $this->appointment->hospital,
        ]);
    }
}
