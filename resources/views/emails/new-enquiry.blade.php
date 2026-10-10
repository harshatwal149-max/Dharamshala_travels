@php
    $e = $enquiry;
    $phone = preg_replace('/[^0-9+]/', '', (string) $e->phone);
    $wa = preg_replace('/\D/', '', (string) $e->phone);
    if (strlen($wa) === 10) { $wa = '91' . $wa; }
@endphp
@include('emails.layout', [
    'heading'    => 'New contact enquiry',
    'subheading' => $e->subject ?: 'General enquiry',
    'rows'       => [
        'Name'    => $e->name,
        'Phone'   => $e->phone,
        'Email'   => $e->email,
        'Subject' => $e->subject,
        'Message' => $e->message,
    ],
    'actions'    => array_filter([
        'Call'          => $phone ? "tel:{$phone}" : null,
        'WhatsApp'      => $wa ? "https://wa.me/{$wa}" : null,
        'Reply by email'=> $e->email ? 'mailto:' . $e->email . '?subject=' . rawurlencode('Re: ' . ($e->subject ?: 'Your enquiry')) : null,
        'Open in admin' => route('admin.inquiries.index'),
    ]),
])
