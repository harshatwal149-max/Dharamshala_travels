{{-- Minimal inline-styled email layout (works in Gmail / Outlook). --}}
@php $site = \App\Models\Setting::get('site_title') ?: 'Dharamshala Travels'; @endphp
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>{{ $heading }}</title></head>
<body style="margin:0;padding:0;background:#f4efe6;font-family:Arial,Helvetica,sans-serif;color:#1c2a25;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4efe6;padding:24px 12px;">
    <tr><td align="center">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:14px;overflow:hidden;">
            <tr><td style="background:#0a1f1a;padding:22px 28px;">
                <div style="color:#f8b84e;font-size:11px;font-weight:bold;letter-spacing:2px;text-transform:uppercase;">{{ $site }} · Admin alert</div>
                <div style="color:#ffffff;font-size:22px;font-weight:bold;margin-top:6px;">{{ $heading }}</div>
                @isset($subheading)<div style="color:#c9d6d1;font-size:13px;margin-top:4px;">{{ $subheading }}</div>@endisset
            </td></tr>
            <tr><td style="padding:24px 28px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-size:14px;">
                    @foreach($rows as $label => $value)
                        @continue(blank($value))
                        <tr>
                            <td style="padding:10px 0;border-bottom:1px solid #ece7dd;color:#78716c;width:38%;vertical-align:top;">{{ $label }}</td>
                            <td style="padding:10px 0;border-bottom:1px solid #ece7dd;font-weight:bold;vertical-align:top;">{!! nl2br(e($value)) !!}</td>
                        </tr>
                    @endforeach
                </table>

                @if(!empty($actions))
                    <div style="margin-top:22px;">
                        @foreach($actions as $label => $href)
                            <a href="{{ $href }}" style="display:inline-block;margin:0 8px 8px 0;padding:11px 18px;border-radius:9px;background:{{ $loop->first ? '#f29b20' : '#1a503f' }};color:{{ $loop->first ? '#0a1f1a' : '#ffffff' }};font-size:13px;font-weight:bold;text-decoration:none;">{{ $label }}</a>
                        @endforeach
                    </div>
                @endif
            </td></tr>
            <tr><td style="padding:16px 28px;background:#faf6ef;color:#a8a29e;font-size:11px;">
                Sent automatically from {{ url('/') }} on {{ now('Asia/Kolkata')->format('d M Y, h:i A') }} IST.
            </td></tr>
        </table>
    </td></tr>
</table>
</body>
</html>
