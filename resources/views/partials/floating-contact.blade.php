@php
    $fcPhone = \App\Models\Setting::get('contact_phone', '+91 98765 43210');
    $fcWhatsapp = \App\Models\Setting::get('footer_whatsapp') ?: $fcPhone;
    $fcWhatsappDigits = preg_replace('/\D/', '', $fcWhatsapp);
@endphp
<div class="fixed bottom-5 right-5 z-40 flex flex-col items-end gap-3">
    <a href="https://wa.me/{{ $fcWhatsappDigits }}?text={{ rawurlencode('Hi Dharamshala Travels, I would like to book a cab.') }}"
       target="_blank" rel="noopener"
       class="flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg shadow-black/20 transition hover:scale-105"
       aria-label="Chat on WhatsApp">
        <svg viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.22 3.08.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35zM12.05 21.5h-.01a9.4 9.4 0 0 1-4.8-1.32l-.34-.2-3.56.93.95-3.47-.23-.36a9.43 9.43 0 1 1 7.99 4.42zm8.02-17.45A11.3 11.3 0 0 0 12.05.73C5.8.73.72 5.8.72 12.05c0 2 .52 3.95 1.52 5.66L.62 23.27l5.7-1.5a11.3 11.3 0 0 0 5.72 1.46h.01c6.25 0 11.33-5.08 11.33-11.33 0-3.03-1.18-5.87-3.31-8.01z"/></svg>
    </a>
    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $fcPhone) }}"
       class="flex h-14 w-14 items-center justify-center rounded-full bg-saffron-500 text-pine-950 shadow-lg shadow-black/20 transition hover:scale-105 md:hidden"
       aria-label="Call us">
        <i data-lucide="phone" class="h-6 w-6"></i>
    </a>
</div>
