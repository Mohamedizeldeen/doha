# Complete Booking System - Step-by-Step Usage Guide

## Table of Contents
1. [Setup](#setup)
2. [Creating Services](#creating-services)
3. [Managing Staff](#managing-staff)
4. [Assigning Services to Staff](#assigning-services-to-staff)
5. [Creating Bookings](#creating-bookings)
6. [Viewing Bookings](#viewing-bookings)
7. [Managing Clients](#managing-clients)
8. [Updating & Deleting Bookings](#updating--deleting-bookings)

---

## Setup

### Database is Ready ✓
All tables have been created:
- `services` - Salon services
- `staff` - Staff members
- `clients` - Client information
- `books` - Bookings/Appointments
- `staff_service` - Links staff to services they provide

### Run Migrations (if needed)
```bash
php artisan migrate
```

---

## Creating Services

### Via API
```bash
POST /salon/{salon_id}/services

{
    "name_en": "Hair Coloring",
    "name_ar": "صبغ الشعر",
    "description_en": "Professional hair coloring service",
    "description_ar": "خدمة صبغ الشعر الاحترافية",
    "price": 50.00,
    "duration_minutes": 90,
    "is_active": true
}
```

### Via Code
```php
use App\Models\Service;

$service = Service::create([
    'salon_id' => 1,
    'name_en' => 'Hair Coloring',
    'name_ar' => 'صبغ الشعر',
    'description_en' => 'Professional hair coloring',
    'description_ar' => 'خدمة صبغ الشعر الاحترافية',
    'price' => 50.00,
    'duration_minutes' => 90,
    'is_active' => true,
]);

// Response
// Service created with ID: $service->id
```

### Get All Services
```php
$services = Service::where('salon_id', 1)->get();

foreach ($services as $service) {
    echo "{$service->name_en} - {$service->name_ar} ({$service->price})";
}
```

---

## Managing Staff

### Create Staff Member
```php
use App\Models\Staff;

$staff = Staff::create([
    'salon_id' => 1,
    'name_en' => 'Sarah Johnson',
    'name_ar' => 'سارة جونسون',
    'email' => 'sarah@salon.com',
    'phone' => '+201234567890',
    'position_en' => 'Hair Stylist',
    'position_ar' => 'مصفف شعر',
]);

// Response
// Staff created with ID: $staff->id
```

### Get All Staff in Salon
```php
$staff = Staff::where('salon_id', 1)->get();

foreach ($staff as $member) {
    echo "{$member->name_en} - {$member->position_en}";
}
```

### Get Staff Details
```php
$staff = Staff::find(1);

echo "Name: {$staff->name_en} ({$staff->name_ar})";
echo "Email: {$staff->email}";
echo "Phone: {$staff->phone}";
echo "Services: " . $staff->services->count();
echo "Bookings: " . $staff->bookings->count();
```

---

## Assigning Services to Staff

### Add One Service
```php
$staff = Staff::find(1);
$serviceId = 1;

$staff->services()->attach($serviceId);

// Now this staff member provides this service
```

### Add Multiple Services
```php
$staff = Staff::find(1);

$staff->services()->attach([1, 2, 3]);

// Staff now provides services 1, 2, and 3
```

### Sync Services (Replace All)
```php
$staff = Staff::find(1);

$staff->services()->sync([1, 2]); 

// Staff now ONLY provides services 1 and 2
// If they had service 3, it's removed
```

### Remove a Service
```php
$staff = Staff::find(1);

$staff->services()->detach(1);

// Staff no longer provides service 1
```

### Get Services for Staff
```php
$staff = Staff::find(1);
$services = $staff->services;  // All services this staff provides

foreach ($services as $service) {
    echo "{$service->name_en} - {$service->price}";
}
```

### Check if Staff Provides Service
```php
$staff = Staff::find(1);
$serviceId = 1;

$provides = $staff->services()
    ->where('service_id', $serviceId)
    ->exists();

if ($provides) {
    echo "Yes, this staff member provides this service";
} else {
    echo "No, this staff member does not provide this service";
}
```

---

## Creating Bookings

### Step-by-Step Booking Creation

#### 1. **Client Auto-Detection Example**

**First Booking - New Client:**
```php
use App\Models\Client;

// System checks if client exists
$client = Client::findExisting(
    salon_id: 1,
    phone: '+201234567890',
    email: 'john@example.com'
);

// Client doesn't exist, so new client will be created
// Database state: 1 client created
```

**Second Booking - Same Client (by phone):**
```php
// Same person books again with same phone number
$client = Client::findExisting(
    salon_id: 1,
    phone: '+201234567890',
    email: 'different@email.com'  // Different email
);

// System finds the existing client by phone!
// Database state: Still 1 client (not duplicated)
```

#### 2. **Create Booking with API**

```bash
POST /salon/1/bookings

{
    "service_id": 1,
    "staff_id": 1,
    "client_name_en": "John Doe",
    "client_name_ar": "جون دو",
    "client_phone": "+201234567890",
    "client_email": "john@example.com",
    "appointment_datetime": "2026-01-25 14:00",
    "notes": "Customer prefers afternoon time"
}
```

**Response (Client is NEW):**
```json
{
    "success": true,
    "message": "Booking created successfully",
    "client_is_new": true,
    "booking": {
        "id": 1,
        "salon_id": 1,
        "client_id": 5,
        "service_id": 1,
        "staff_id": 1,
        "appointment_datetime": "2026-01-25T14:00:00",
        "status": "scheduled",
        "price": "50.00",
        "notes": "Customer prefers afternoon time"
    }
}
```

#### 3. **Create Booking with Code**

```php
use App\Models\Book;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;

$salonId = 1;
$serviceId = 1;
$staffId = 1;

// Validate service belongs to salon
$service = Service::findOrFail($serviceId);
if ($service->salon_id !== $salonId) {
    return error('Service not in this salon');
}

// Validate staff belongs to salon
$staff = Staff::findOrFail($staffId);
if ($staff->salon_id !== $salonId) {
    return error('Staff not in this salon');
}

// Check staff provides this service
if (!$staff->services()->where('service_id', $serviceId)->exists()) {
    return error('This staff member does not provide this service');
}

// Find or create client
$client = Client::findExisting(
    $salonId,
    $phone = '+201234567890',
    $email = 'john@example.com'
);

if (!$client) {
    // Client doesn't exist, create new one
    $client = Client::create([
        'salon_id' => $salonId,
        'client_code' => 'CLI-' . strtoupper(Str::random(8)),
        'name_en' => 'John Doe',
        'name_ar' => 'جون دو',
        'phone' => '+201234567890',
        'email' => 'john@example.com',
    ]);
    
    echo "New client created: {$client->client_code}";
} else {
    echo "Existing client found: {$client->client_code}";
}

// Create booking
$booking = Book::create([
    'salon_id' => $salonId,
    'client_id' => $client->id,
    'service_id' => $serviceId,
    'staff_id' => $staffId,
    'appointment_datetime' => '2026-01-25 14:00:00',
    'price' => $service->price,  // Lock price
    'notes' => 'Customer prefers afternoon time',
    'status' => 'scheduled',
]);

echo "Booking created: ID {$booking->id}";
```

---

## Viewing Bookings

### Get All Bookings for Salon
```php
use App\Models\Salon;

$salon = Salon::find(1);
$bookings = $salon->bookings;

foreach ($bookings as $booking) {
    echo "ID: {$booking->id}";
    echo "Client: {$booking->client->name_en}";
    echo "Service: {$booking->service->name_en}";
    echo "Staff: {$booking->staff->name_en}";
    echo "Date: {$booking->appointment_datetime}";
    echo "Status: {$booking->status}";
    echo "Price: {$booking->price}";
    echo "---";
}
```

### Get Bookings by Date
```bash
GET /salon/1/bookings/date/2026-01-25
```

```php
$salon = Salon::find(1);
$date = '2026-01-25';

$bookings = $salon->bookings()
    ->whereDate('appointment_datetime', $date)
    ->with('client', 'service', 'staff')
    ->orderBy('appointment_datetime')
    ->get();

foreach ($bookings as $booking) {
    echo "{$booking->appointment_datetime->format('H:i')} - {$booking->client->name_en}";
}
```

### Get Staff Schedule (Specific Date)
```bash
GET /salon/1/staff/1/schedule/2026-01-25
```

```php
$staff = Staff::find(1);
$date = '2026-01-25';

$bookings = $staff->bookings()
    ->where('salon_id', 1)
    ->whereDate('appointment_datetime', $date)
    ->with('client', 'service')
    ->orderBy('appointment_datetime')
    ->get();

echo "Schedule for {$staff->name_en}:";
foreach ($bookings as $booking) {
    $time = $booking->appointment_datetime->format('H:i');
    $duration = $booking->service->duration_minutes;
    echo "$time ({$duration}min) - {$booking->client->name_en}";
}
```

### Get Client Booking History
```bash
GET /salon/1/clients/1/history
```

```php
use App\Models\Client;

$client = Client::find(1);
$bookings = $client->bookings()
    ->where('salon_id', 1)
    ->with('service', 'staff')
    ->orderBy('appointment_datetime', 'desc')
    ->get();

echo "Booking history for {$client->name_en}:";
foreach ($bookings as $booking) {
    echo "{$booking->appointment_datetime} - {$booking->service->name_en}";
    echo "with {$booking->staff->name_en}";
}
```

### Get Upcoming Bookings
```php
$bookings = Book::where('salon_id', 1)
    ->where('status', 'scheduled')
    ->where('appointment_datetime', '>=', now())
    ->with('client', 'service', 'staff')
    ->orderBy('appointment_datetime')
    ->get();

foreach ($bookings as $booking) {
    echo "{$booking->client->name_en} - {$booking->service->name_en}";
}
```

### Get Past Bookings
```php
$bookings = Book::where('salon_id', 1)
    ->where('appointment_datetime', '<', now())
    ->with('client', 'service', 'staff')
    ->orderBy('appointment_datetime', 'desc')
    ->get();
```

---

## Managing Clients

### View All Clients
```php
use App\Models\Salon;

$salon = Salon::find(1);
$clients = $salon->clients;

foreach ($clients as $client) {
    echo "Code: {$client->client_code}";
    echo "Name: {$client->name_en} ({$client->name_ar})";
    echo "Phone: {$client->phone}";
    echo "Email: {$client->email}";
    echo "Bookings: " . $client->bookings->count();
}
```

### Find Specific Client
```php
use App\Models\Client;

// Find by ID
$client = Client::find(1);

// Find by client code
$client = Client::where('client_code', 'CLI-ABC12345')->first();

// Find by phone or email
$client = Client::findExisting(1, '+201234567890', 'john@example.com');
```

### Update Client Info
```php
$client = Client::find(1);

$client->update([
    'name_en' => 'John Updated',
    'name_ar' => 'جون محدث',
    'phone' => '+201234567890',
    'email' => 'newemail@example.com',
]);
```

### Client Statistics
```php
$client = Client::find(1);

$totalBookings = $client->bookings()->count();
$completedBookings = $client->bookings()->where('status', 'completed')->count();
$upcomingBookings = $client->bookings()
    ->where('status', 'scheduled')
    ->where('appointment_datetime', '>=', now())
    ->count();

$totalSpent = $client->bookings()
    ->where('status', 'completed')
    ->sum('price');

echo "Total bookings: {$totalBookings}";
echo "Completed: {$completedBookings}";
echo "Upcoming: {$upcomingBookings}";
echo "Total spent: {$totalSpent}";
```

---

## Updating & Deleting Bookings

### Update Booking Status
```bash
PATCH /salon/1/bookings/1/status

{
    "status": "completed"
}
```

```php
use App\Models\Book;

$booking = Book::find(1);

// Mark as completed
$booking->update(['status' => 'completed']);

// Mark as canceled
$booking->update(['status' => 'canceled']);
```

### Update Booking Notes
```php
$booking = Book::find(1);

$booking->update([
    'notes' => 'Client asked for lighter color',
]);
```

### Delete Booking
```bash
DELETE /salon/1/bookings/1
```

```php
$booking = Book::find(1);
$booking->delete();

// If booking is past, you might want to archive instead:
$booking->update(['status' => 'canceled']);
```

---

## Advanced Queries

### Get Staff Availability
```php
$staff = Staff::find(1);
$date = '2026-01-25';
$workStartHour = 9;
$workEndHour = 17;

$bookings = $staff->bookings()
    ->where('salon_id', 1)
    ->whereDate('appointment_datetime', $date)
    ->with('service')
    ->get();

// Create hourly slots
for ($hour = $workStartHour; $hour < $workEndHour; $hour++) {
    $isAvailable = !$bookings->some(function($booking) use ($hour) {
        $bookingHour = $booking->appointment_datetime->hour;
        $duration = $booking->service->duration_minutes / 60;
        return $bookingHour <= $hour < ($bookingHour + $duration);
    });
    
    echo "$hour:00 - " . ($isAvailable ? 'Available' : 'Booked');
}
```

### Revenue Report
```php
$salonId = 1;
$month = '2026-01';

$revenue = Book::where('salon_id', $salonId)
    ->where('status', 'completed')
    ->whereLike('appointment_datetime', "$month%")
    ->sum('price');

echo "Revenue for $month: {$revenue}";
```

### Most Popular Services
```php
use App\Models\Service;

$services = Service::where('salon_id', 1)
    ->withCount(['bookings' => function($query) {
        $query->where('status', 'completed');
    }])
    ->orderByDesc('bookings_count')
    ->get();

foreach ($services as $service) {
    echo "{$service->name_en}: {$service->bookings_count} bookings";
}
```

### Top Earner Staff
```php
use App\Models\Staff;

$staff = Staff::where('salon_id', 1)
    ->with(['bookings' => function($query) {
        $query->where('status', 'completed');
    }])
    ->get()
    ->map(function($member) {
        $member->total_revenue = $member->bookings->sum('price');
        return $member;
    })
    ->sortByDesc('total_revenue');

foreach ($staff as $member) {
    echo "{$member->name_en}: {$member->total_revenue}";
}
```

---

## Summary

✅ **Complete Booking System Implemented:**
- Services with bilingual support
- Staff management with multi-service capability
- Automatic client deduplication
- Comprehensive booking management
- Rich query capabilities
- Full authorization and validation

🎯 **Key Features:**
- Each staff can provide multiple services
- Clients automatically detected by phone/email
- Price locked at booking time
- Bilingual Arabic/English support
- Complete audit trail with timestamps
