<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'title' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

       Contact::create($validated);

        return redirect()->to(url()->previous() . '#contact-form')->with('success', __('messages.contact_received'));
    }

    /**
     * Show all contacts for super admin
     */
    public function superAdminIndex()
    {
        $contacts = Contact::latest('created_at')->paginate(20);

        return view('superAdmin.contacts.index', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * Show contact details for super admin
     */
    public function superAdminShow(Contact $contact)
    {
        return view('superAdmin.contacts.show', [
            'contact' => $contact,
        ]);
    }

    /**
     * Delete a contact for super admin
     */
    public function superAdminDestroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('superAdmin.contacts.index')
            ->with('success', __('messages.contact_deleted'));
    }
}