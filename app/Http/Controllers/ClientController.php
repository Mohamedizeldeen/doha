<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Get all clients for a salon
     */
    public function index(Salon $salon)
    {
        $this->authorize('own', $salon);

        $clients = $salon->clients()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('clients.index', compact('salon', 'clients'));
    }

    /**
     * Show client creation form
     */
    public function create(Salon $salon)
    {
        $this->authorize('own', $salon);
        return view('clients.create', compact('salon'));
    }

    /**
     * Store a new client manually
     */
    public function store(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $validated = $request->validate([
            'client_code' => 'nullable|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'phone' => 'required|regex:/^[0-9+\-\s()]{7,20}$/',
            'email' => 'required|email',
        ]);

        // Check for existing client with same phone/email
        $existing = Client::findExisting(
            $salon->id,
            $validated['phone'],
            $validated['email']
        );

        if ($existing) {
            return back()->with('error', 'Client with this phone or email already exists');
        }

        // Generate client code if not provided
        $clientCode = $validated['client_code'] ?? $this->generateClientCode($salon);

        Client::create([
            'salon_id' => $salon->id,
            'client_code' => $clientCode,
            'name_en' => $validated['name_en'],
            'name_ar' => $validated['name_ar'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
        ]);

        return redirect()->route('client.index', $salon)
            ->with('success', 'Client created successfully');
    }

    /**
     * Get a single client with booking history
     */
    public function show(Salon $salon, Client $client)
    {
        $this->authorize('own', $salon);
        $this->authorizeClientBelongsToSalon($client, $salon);
        // Calculate total money from all bookings
        $client->load('bookings.service');
        $totalBookingsMoney = $client->bookings->where('status', 'completed')->sum('service.price');

        return view('clients.show', compact('salon', 'client', 'totalBookingsMoney'));
    }

    /**
     * Show client edit form
     */
    public function edit(Salon $salon, Client $client)
    {
        $this->authorize('own', $salon);
        $this->authorizeClientBelongsToSalon($client, $salon);

        return view('clients.edit', compact('salon', 'client'));
    }

    /**
     * Update a client
     */
    public function update(Request $request, Salon $salon, Client $client)
    {
        $this->authorize('own', $salon);
        $this->authorizeClientBelongsToSalon($client, $salon);

        $validated = $request->validate([
            'client_code' => 'nullable|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'phone' => 'required|regex:/^[0-9+\-\s()]{7,20}$/',
            'email' => 'required|email',
        ]);

        // Check for existing client with same phone/email (excluding current client)
        $existing = Client::where('salon_id', $salon->id)
            ->where(function ($query) use ($validated) {
                $query->where('phone', $validated['phone'])
                    ->orWhere('email', $validated['email']);
            })
            ->where('id', '!=', $client->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Another client with this phone or email already exists');
        }

        $client->update($validated);

        return redirect()->route('client.show', [$salon, $client])
            ->with('success', 'Client updated successfully');
    }

    /**
     * Delete a client
     */
    public function destroy(Salon $salon, Client $client)
    {
        $this->authorize('own', $salon);
        $this->authorizeClientBelongsToSalon($client, $salon);

        // Delete all associated bookings
        $client->bookings()->delete();

        $client->delete();

        return redirect()->route('client.index', $salon)
            ->with('success', 'Client deleted successfully');
    }

    /**
     * Generate unique client code for salon
     */
    private function generateClientCode(Salon $salon): string
    {
        $salonCode = strtoupper(substr($salon->name, 0, 3));
        $count = $salon->clients()->count() + 1;
        return "{$salonCode}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Authorize client belongs to salon
     */
    private function authorizeClientBelongsToSalon($client, $salon)
    {
        if ($client->salon_id !== $salon->id) {
            abort(403, 'Client does not belong to this salon');
        }
    }
}
