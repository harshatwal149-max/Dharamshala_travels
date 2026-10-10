@php
    $b = $booking;
    $phone = preg_replace('/[^0-9+]/', '', $b->customer_phone);
    $wa = preg_replace('/\D/', '', $b->customer_phone);
    if (strlen($wa) === 10) { $wa = '91' . $wa; }
    $types = ['airport' => 'Airport transfer', 'local' => 'Local sightseeing', 'outstation' => 'Outstation', 'package' => 'Tour package'];
@endphp
@include('emails.layout', [
    'heading'    => 'New booking request',
    'subheading' => "Reference {$b->booking_code}",
    'rows'       => [
        'Booking type'    => $types[$b->booking_type] ?? ucfirst((string) $b->booking_type),
        'Customer'        => $b->customer_name,
        'Phone'           => $b->customer_phone,
        'Email'           => $b->customer_email,
        'Travel date'     => optional($b->travel_date)->format('l, d M Y'),
        'Travel time'     => $b->travel_time,
        'Pickup'          => $b->pickup_location,
        'Drop'            => $b->drop_location,
        'Cab'             => $b->vehicle ? "{$b->vehicle->name} ({$b->vehicle->category})" : 'Any available cab',
        'Tour package'    => $b->package?->title,
        'Notes'           => $b->notes,
        'Booking code'    => $b->booking_code,
    ],
    'actions'    => array_filter([
        'Call customer'      => $phone ? "tel:{$phone}" : null,
        'WhatsApp customer'  => $wa ? "https://wa.me/{$wa}" : null,
        'Open in admin'      => route('admin.bookings.index'),
    ]),
])
