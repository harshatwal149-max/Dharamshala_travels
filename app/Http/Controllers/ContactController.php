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
        return view('contact');
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

        Enquiry::create($validated);

        return back()->with('enquiry_success', 'Thank you! Your enquiry has been received. Our team will contact you shortly.');
    }
}