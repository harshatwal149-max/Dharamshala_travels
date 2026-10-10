@if(session('booking_success'))
    <script>
        window.addEventListener('load', function () {
            if (!window.Swal) return;
            Swal.fire({
                icon: 'success',
                title: @json('Thank you, ' . session('customer_name') . '!'),
                html: `
                    <p style="margin-bottom:12px;color:#57534e">Your booking request has been received. Our travel desk will call you shortly to confirm the pickup details.</p>
                    <div style="display:inline-block;padding:10px 18px;border-radius:12px;background:#eef7f3;border:1px dashed #2a7c60">
                        <div style="font-size:11px;color:#57534e;text-transform:uppercase;letter-spacing:.1em">Booking reference</div>
                        <div style="font-size:20px;font-weight:800;letter-spacing:.12em;color:#0a1f1a">{{ e(session('booking_code')) }}</div>
                    </div>
                    <p style="margin-top:12px;font-size:13px;color:#57534e">Travel date: <strong>{{ e(\Illuminate\Support\Carbon::parse(session('travel_date'))->format('d M Y')) }}</strong></p>
                `,
                confirmButtonText: 'Done',
                confirmButtonColor: '#1a503f',
            });
        });
    </script>
@endif
