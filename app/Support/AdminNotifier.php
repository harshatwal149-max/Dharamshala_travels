<?php

namespace App\Support;

use App\Mail\NewBookingMail;
use App\Mail\NewEnquiryMail;
use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AdminNotifier
{
    /**
     * Admin addresses that receive booking & enquiry alerts.
     *
     * Uses the "Admin notification emails" setting (comma / newline separated),
     * falling back to the public contact email, then MAIL_FROM_ADDRESS.
     */
    public static function recipients(): array
    {
        $raw = Setting::get('admin_notification_emails')
            ?: Setting::get('contact_email')
            ?: config('mail.from.address');

        return collect(preg_split('/[\s,;]+/', (string) $raw))
            ->map(fn ($email) => strtolower(trim($email)))
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values()
            ->all();
    }

    public static function booking(Booking $booking): void
    {
        static::send(new NewBookingMail($booking), "booking {$booking->booking_code}");
    }

    public static function enquiry(Enquiry $enquiry): void
    {
        static::send(new NewEnquiryMail($enquiry), "enquiry #{$enquiry->id}");
    }

    /**
     * Queue the mail; never let a mail problem break the customer's form submission.
     */
    protected static function send($mailable, string $label): void
    {
        $to = static::recipients();

        if (empty($to)) {
            Log::warning("Admin notification skipped for {$label}: no recipient email configured.");
            return;
        }

        try {
            Mail::to($to)->queue($mailable);
        } catch (Throwable $e) {
            Log::error("Admin notification failed for {$label}: " . $e->getMessage());
        }
    }
}
