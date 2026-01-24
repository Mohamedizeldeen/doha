# Complete Booking & Services System Documentation

## Database Structure Overview

### Tables and Relationships

```
User (1) ──── (Many) Salon
            ↓
        ├─ (Many) Staff
        ├─ (Many) Service
        ├─ (Many) Client
        └─ (Many) Book
        
Staff (Many) ←──→ (Many) Service [via staff_service pivot table]
                        ↓
                    Book (Many)
                        ↓
                    Client
```

## Tables Description

### 1. **services** table
Stores all beauty salon services available in each salon.

**Columns:**
- `id` - Primary key
- `salon_id` - Foreign key to salons table (cascade delete)
- `name_en` - Service name in English
- `name_ar` - Service name in Arabic
- `description_en` - Service description in English
- `description_ar` - Service description in Arabic
- `price` - Service price (decimal, 8,2)
- `duration_minutes` - Service duration in minutes
- `is_active` - Boolean flag for active/inactive services
- `timestamps` - created_at, updated_at

**Key Features:**
- Each service belongs to ONE salon
- Services have bilingual support (English & Arabic)
- Price is stored as decimal for accuracy
- Active status to enable/disable services

---

### 2. **staff_service** (Pivot Table)
Creates a many-to-many relationship between staff and services.

**Columns:**
- `id` - Primary key
- `staff_id` - Foreign key to staff table (cascade delete)
- `service_id` - Foreign key to services table (cascade delete)
- `timestamps` - created_at, updated_at
- **Unique constraint**: `[staff_id, service_id]` - Each staff member can only have one entry per service

**Key Features:**
- Allows each staff member to provide MULTIPLE services
- Prevents duplicate entries (unique constraint)
- Automatically deleted when staff or service is deleted

---

### 3. **clients** table
Stores client information for each salon.

**Columns:**
- `id` - Primary key
- `salon_id` - Foreign key to salons table (cascade delete)
- `client_code` - Unique client identifier (e.g., CLI-ABC123XY)
- `name_en` - Client name in English
- `name_ar` - Client name in Arabic
- `phone` - Client phone number (optional)
- `email` - Client email address (optional)
- `timestamps` - created_at, updated_at

**Key Features:**
- Each client belongs to ONE salon
- Unique `client_code` for identification
- Bilingual name support
- Phone/email are optional

---

### 4. **books** table (Bookings/Appointments)
Stores all client bookings for services.

**Columns:**
- `id` - Primary key
- `salon_id` - Foreign key to salons table (cascade delete)
- `client_id` - Foreign key to clients table (cascade delete)
- `service_id` - Foreign key to services table (cascade delete)
- `staff_id` - Foreign key to staff table (cascade delete) **[NEW]**
- `appointment_datetime` - Date and time of the appointment
- `status` - Enum: 'scheduled', 'completed', 'canceled'
- `price` - Price at time of booking (decimal, 8,2) **[NEW]**
- `notes` - Additional notes (optional) **[NEW]**
- `timestamps` - created_at, updated_at
- **Indexes:**
  - `[salon_id, appointment_datetime]`
  - `[client_id, salon_id]`
  - `[staff_id, appointment_datetime]`

**Key Features:**
- Booking requires: Service + Staff + Client
- Staff member MUST provide the selected service
- Price is locked at time of booking (historical accuracy)
- Indexed for fast lookups by salon/date and staff/date
- Status tracking (scheduled/completed/canceled)

---

## Model Relationships

### **Staff Model**
```php
// Staff can provide many services
services() -> BelongsToMany(Service::class, 'staff_service')

// Staff can have many bookings
bookings() -> HasMany(Book::class)

// Staff belongs to a salon
salon() -> BelongsTo(Salon::class)
```

### **Service Model**
```php
// Service is provided by many staff members
staff() -> BelongsToMany(Staff::class, 'staff_service')

// Service can have many bookings
bookings() -> HasMany(Book::class)

// Service belongs to a salon
salon() -> BelongsTo(Salon::class)
```

### **Client Model**
```php
// Client has many bookings
bookings() -> HasMany(Book::class)

// Client belongs to a salon
salon() -> BelongsTo(Salon::class)

// Static method to find existing client
findExisting($salonId, $phone = null, $email = null)
```

### **Book Model**
```php
// Booking belongs to a salon
salon() -> BelongsTo(Salon::class)

// Booking belongs to a client
client() -> BelongsTo(Client::class)

// Booking is for a service
service() -> BelongsTo(Service::class)

// Booking is with a staff member
staff() -> BelongsTo(Staff::class)

// Helper methods
isPast() -> bool
isUpcoming() -> bool
```

### **Salon Model** (Updated)
```php
// Salon has many staff members
staff() -> HasMany(Staff::class)

// Salon has many services
services() -> HasMany(Service::class)

// Salon has many clients
clients() -> HasMany(Client::class)

// Salon has many bookings
bookings() -> HasMany(Book::class)
```

---

## BookingController Logic

### Key Feature: Automatic Client Handling

When creating a booking, the system **automatically checks if the client already exists**:

```php
// Find existing client by phone OR email for this salon
$client = Client::findExisting(
    $salon->id,
    $validated['client_phone'],
    $validated['client_email'] ?? null
);

// If client doesn't exist, create new one
if (!$client) {
    $client = Client::create([
        'salon_id' => $salon->id,
        'client_code' => $this->generateClientCode($salon->id),
        'name_en' => $validated['client_name_en'],
        'name_ar' => $validated['client_name_ar'],
        'phone' => $validated['client_phone'],
        'email' => $validated['client_email'] ?? null,
    ]);
}
```

**Benefits:**
- Prevents duplicate clients
- Maintains accurate client database
- Automatic client code generation
- Reuses existing client data

---

## API Endpoints

### Create Booking
```
POST /salon/{salon_id}/booking
```
**Request Body:**
```json
{
    "service_id": 1,
    "staff_id": 1,
    "client_name_en": "John Doe",
    "client_name_ar": "جون دو",
    "client_phone": "+201234567890",
    "client_email": "john@example.com",
    "appointment_datetime": "2026-01-25 14:00",
    "notes": "Optional notes"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Booking created successfully",
    "booking": { ... },
    "client_is_new": false
}
```

### Get All Bookings
```
GET /salon/{salon_id}/bookings
```
Returns all bookings with client, service, and staff details.

### Get Bookings by Date
```
GET /salon/{salon_id}/bookings/date/{date}
```
Returns bookings for a specific date (format: YYYY-MM-DD).

### Get Staff Schedule
```
GET /salon/{salon_id}/staff/{staff_id}/schedule/{date}
```
Returns all appointments for a staff member on a specific date.

### Get Client History
```
GET /salon/{salon_id}/clients/{client_id}/history
```
Returns all bookings for a specific client.

### Update Booking Status
```
PATCH /salon/{salon_id}/bookings/{booking_id}/status
```
**Request Body:**
```json
{
    "status": "completed"
}
```

### Delete Booking
```
DELETE /salon/{salon_id}/bookings/{booking_id}
```

---

## Data Validation

### Booking Creation Validation

| Field | Rules |
|-------|-------|
| `service_id` | required, exists in services table |
| `staff_id` | required, exists in staff table |
| `client_name_en` | required, string, max 255 |
| `client_name_ar` | required, string, max 255 |
| `client_phone` | required, string, max 20 |
| `client_email` | nullable, email format |
| `appointment_datetime` | required, format Y-m-d H:i, must be in future |
| `notes` | nullable, string |

### Additional Validations

1. **Service Belongs to Salon**: Validates that selected service belongs to the booking salon
2. **Staff Belongs to Salon**: Validates that selected staff belongs to the booking salon
3. **Staff Provides Service**: Validates that selected staff member provides the selected service
4. **Existing Client Check**: Checks if client exists by phone or email before creating new client

---

## Migration Files Created/Updated

### New Migrations
- `2026_01_20_192801_create_staff_service_table.php` - Pivot table for staff-service relationship

### Updated Migrations
- `2026_01_20_191202_create_services_table.php` - Added `is_active` field and corrected price decimal
- `2026_01_20_191437_create_books_table.php` - Added `staff_id`, `price`, `notes` fields and indexes

---

## Usage Example

### Create a Service
```php
$service = Service::create([
    'salon_id' => $salon->id,
    'name_en' => 'Hair Coloring',
    'name_ar' => 'صبغ الشعر',
    'price' => 50.00,
    'duration_minutes' => 90,
    'is_active' => true,
]);
```

### Assign Service to Staff
```php
// Add service to staff's services
$staff->services()->attach($service->id);

// Or with multiple services
$staff->services()->attach([1, 2, 3]);
```

### Create a Booking
```php
$booking = Book::create([
    'salon_id' => $salon->id,
    'client_id' => $client->id,
    'service_id' => $service->id,
    'staff_id' => $staff->id,
    'appointment_datetime' => '2026-01-25 14:00',
    'price' => 50.00,
    'notes' => 'Customer prefers afternoon slots',
    'status' => 'scheduled',
]);
```

### Find Bookings for Staff on a Date
```php
$bookings = $staff->bookings()
    ->where('salon_id', $salon->id)
    ->whereDate('appointment_datetime', '2026-01-25')
    ->with('client', 'service')
    ->get();
```

### Get Client Booking History
```php
$history = $client->bookings()
    ->where('salon_id', $salon->id)
    ->with('service', 'staff')
    ->orderBy('appointment_datetime', 'desc')
    ->get();
```

---

## Key Design Decisions

1. **Many-to-Many Staff-Service**: Allows flexibility where one staff member can provide multiple services
2. **Client Deduplication**: Automatic detection prevents duplicate client records
3. **Price Locking**: Service price is stored at booking time for historical accuracy
4. **Status Tracking**: Bookings track lifecycle (scheduled → completed/canceled)
5. **Bilingual Support**: All text fields support English and Arabic
6. **Comprehensive Indexing**: Database queries optimized for common lookups
7. **Authorization Checks**: All booking operations verify user owns the salon

---

## Database Diagram

```
┌─────────────────┐
│     Salon       │
├─────────────────┤
│ id (PK)         │
│ user_id (FK)    │
│ name_en         │
│ name_ar         │
│ subscription... │
└─────────────────┘
    ↓    ↓    ↓
    │    │    └── clients
    │    └─────── staff
    └────────── services

┌──────────────────┐      ┌──────────────────┐
│      Staff       │◄────►│     Service      │
├──────────────────┤ M:M  ├──────────────────┤
│ id (PK)          │      │ id (PK)          │
│ salon_id (FK)    │      │ salon_id (FK)    │
│ name_en          │      │ name_en          │
│ name_ar          │      │ name_ar          │
│ email (UNIQUE)   │      │ price            │
│ phone            │      │ duration_minutes │
└──────────────────┘      │ is_active        │
    ↓                      └──────────────────┘
    │ (1)                        ↑ (1)
    │ books (Many)               │
    │                            │
    ▼                            │
┌──────────────────┐      ┌──────────────────┐
│       Book       │      │    Pivot Table   │
├──────────────────┤      ├──────────────────┤
│ id (PK)          │      │ id (PK)          │
│ salon_id (FK)    │      │ staff_id (FK)    │
│ client_id (FK)   │      │ service_id (FK)  │
│ service_id (FK)  │      │ UNIQUE[staff,srv]│
│ staff_id (FK)    │      └──────────────────┘
│ appointment_date │
│ status           │
│ price            │
│ notes            │
└──────────────────┘
    ↓
    │ (1)
    │ client (Many)
    │
┌──────────────────┐
│     Client       │
├──────────────────┤
│ id (PK)          │
│ salon_id (FK)    │
│ client_code (UK) │
│ name_en          │
│ name_ar          │
│ phone            │
│ email            │
└──────────────────┘
```

---

## Summary

This complete booking system ensures:
- ✅ Each staff member can provide multiple services
- ✅ Bookings are for client + service combinations
- ✅ Existing clients are reused (not duplicated)
- ✅ Price is locked at booking time
- ✅ Full authorization and validation
- ✅ Bilingual support throughout
- ✅ Efficient database queries with proper indexing
