<?php

namespace Tests\Feature;

use App\Mail\NewBookingMail;
use App\Mail\NewEnquiryMail;
use App\Models\Setting;
use App\Models\Vehicle;
use App\Support\AdminNotifier;
use Database\Seeders\VehicleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_request_emails_all_admin_addresses(): void
    {
        Mail::fake();
        $this->seed(VehicleSeeder::class);
        Setting::set('admin_notification_emails', "owner@example.com,\nbookings@example.com; not-an-email");

        $this->post(route('bookings.store'), [
            'booking_type'    => 'airport',
            'customer_name'   => 'Asha',
            'customer_phone'  => '9816012345',
            'travel_date'     => now()->toDateString(),
            'pickup_location' => 'Gaggal Airport (DHM)',
            'drop_location'   => 'McLeodganj',
            'vehicle_id'      => Vehicle::first()->id,
        ])->assertRedirect();

        Mail::assertQueued(NewBookingMail::class, function (NewBookingMail $mail) {
            return $mail->hasTo('owner@example.com')
                && $mail->hasTo('bookings@example.com')
                && ! $mail->hasTo('not-an-email')
                && $mail->booking->customer_name === 'Asha';
        });
    }

    public function test_contact_enquiry_emails_admin_with_reply_to_customer(): void
    {
        Mail::fake();
        Setting::set('contact_email', 'desk@example.com');

        $this->post(route('contact.store'), [
            'name'    => 'Ravi',
            'phone'   => '9816012345',
            'email'   => 'ravi@example.com',
            'subject' => 'Tour package',
            'message' => 'Planning a trip in May.',
        ])->assertRedirect();

        Mail::assertQueued(NewEnquiryMail::class, fn (NewEnquiryMail $mail) =>
            $mail->hasTo('desk@example.com') && $mail->hasReplyTo('ravi@example.com'));
    }

    public function test_notification_email_renders(): void
    {
        $this->seed(VehicleSeeder::class);

        $booking = \App\Models\Booking::create([
            'booking_code' => 'DT-TEST01', 'booking_type' => 'outstation', 'customer_name' => 'Asha',
            'customer_phone' => '9816012345', 'travel_date' => now(), 'pickup_location' => 'Dharamshala',
            'drop_location' => 'Manali', 'vehicle_id' => Vehicle::first()->id, 'estimated_fare' => 0, 'status' => 'pending',
        ]);

        $html = (new NewBookingMail($booking))->render();

        $this->assertStringContainsString('DT-TEST01', $html);
        $this->assertStringContainsString('Manali', $html);
        $this->assertStringContainsString('wa.me/919816012345', $html);
    }

    public function test_falls_back_to_contact_email(): void
    {
        Setting::set('admin_notification_emails', null);
        Setting::set('contact_email', 'info@example.com');

        $this->assertSame(['info@example.com'], AdminNotifier::recipients());
    }
}
