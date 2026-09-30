<!DOCTYPE html>
<html><body style="font-family:Arial,sans-serif;background:#f4f6f4;padding:24px">
<div style="max-width:520px;margin:auto;background:#fff;border-radius:12px;overflow:hidden">
    <div style="background:{{ $hospital->primary_color }};color:#fff;padding:20px 28px">
        <h2 style="margin:0">{{ $hospital->name }}</h2>
    </div>
    <div style="padding:28px">
        <h3>Hello {{ $appointment->patient_name }},</h3>
        <p>Your appointment has been <strong>{{ $appointment->status }}</strong>.</p>
        <table style="width:100%;font-size:14px;border-collapse:collapse">
            <tr><td style="padding:6px 0;color:#666">Reference</td><td><strong>{{ $appointment->reference_code }}</strong></td></tr>
            <tr><td style="padding:6px 0;color:#666">Doctor</td><td>{{ $appointment->doctor->name }}</td></tr>
            <tr><td style="padding:6px 0;color:#666">Date</td><td>{{ $appointment->appointment_date->format('D, d M Y') }}</td></tr>
            <tr><td style="padding:6px 0;color:#666">Time</td><td>{{ substr($appointment->slot_time, 0, 5) }}</td></tr>
            @if($appointment->token_no)<tr><td style="padding:6px 0;color:#666">Token</td><td>#{{ $appointment->token_no }}</td></tr>@endif
        </table>
        <p style="color:#666;font-size:13px;margin-top:20px">Please arrive 10 minutes early. For changes call {{ $hospital->phone }}.</p>
    </div>
</div>
</body></html>
