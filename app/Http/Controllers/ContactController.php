<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the Contact / Enquiry page.
     */
    public function index()
    {
        $faqs = [
            ['How quickly will you reply?',
                'We usually call or WhatsApp back within minutes between 6 AM and 11 PM. Messages sent at night are answered first thing in the morning.'],
            ['Can I book directly on WhatsApp?',
                'Yes. Send your pickup point, destination, travel date and number of passengers on WhatsApp and we will confirm your cab.'],
            ['Do you arrange late-night airport pickups?',
                'Yes. Share your flight number in advance and a driver will be waiting at Gaggal Airport arrivals, even for late flights.'],
            ['Where is your office?',
                'Our desk is in Dharamshala, and our drivers cover McLeodganj, Bhagsu, Dharamkot, Kangra and the whole of Himachal Pradesh.'],
        ];

        $seo = [
            'title'       => 'Contact Dharamshala Travels — Taxi & Tour Booking Desk',
            'description' => 'Call, WhatsApp or email Dharamshala Travels to book Gaggal Airport taxis, McLeodganj sightseeing, outstation cabs and Himachal tour packages.',
            'keywords'    => 'dharamshala travels contact, dharamshala taxi number, mcleodganj taxi contact, gaggal airport taxi booking',
            'image'       => '/images/dharamshala/mcleodganj-view.jpg',
            'breadcrumbs' => ['Contact' => route('contact')],
            'schema'      => [
                ['@type' => 'ContactPage', 'name' => 'Contact Dharamshala Travels', 'url' => route('contact')],
                PageController::faqSchema($faqs),
            ],
        ];

        return view('contact', compact('faqs', 'seo'));
    }

    /**
     * Store a new enquiry in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'nullable|email|max:150',
            'phone'   => 'required|string|max:20',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        $enquiry = Enquiry::create($validated);

        \App\Support\AdminNotifier::enquiry($enquiry);

        return back()->with('enquiry_success', 'Thank you! Your enquiry has been received. Our team will contact you shortly.');
    }
}