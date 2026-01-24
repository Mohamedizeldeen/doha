# Database Schema - Quick Reference

## Complete Table Definitions

### services TABLE
```sql
CREATE TABLE services (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    salon_id BIGINT UNSIGNED NOT NULL,
    name_en VARCHAR(255) NOT NULL,
    name_ar VARCHAR(255) NOT NULL,
    description_en TEXT NULL,
    description_ar TEXT NULL,
    price DECIMAL(8, 2) NOT NULL,
    duration_minutes INT NOT NULL,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (salon_id) REFERENCES salons(id) ON DELETE CASCADE,
    INDEX idx_salon_id (salon_id)
);
```

**Example Data:**
```
id | salon_id | name_en         | name_ar        | price | duration_minutes
1  | 1        | Hair Coloring   | صبغ الشعر       | 50.00 | 90
2  | 1        | Haircut         | قص الشعر        | 25.00 | 30
3  | 1        | Facial          | تنظيف الوجه     | 40.00 | 60
```

---

### staff_service TABLE (Pivot)
```sql
CREATE TABLE staff_service (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    staff_id BIGINT UNSIGNED NOT NULL,
    service_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    UNIQUE KEY unique_staff_service (staff_id, service_id)
);
```

**Example Data:**
```
id | staff_id | service_id
1  | 1        | 1          (Staff 1 provides service 1)
2  | 1        | 2          (Staff 1 provides service 2)
3  | 2        | 1          (Staff 2 provides service 1)
4  | 2        | 3          (Staff 2 provides service 3)
```

---

### clients TABLE
```sql
CREATE TABLE clients (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    salon_id BIGINT UNSIGNED NOT NULL,
    client_code VARCHAR(255) NOT NULL UNIQUE,
    name_en VARCHAR(255) NOT NULL,
    name_ar VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    email VARCHAR(255) NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (salon_id) REFERENCES salons(id) ON DELETE CASCADE,
    INDEX idx_salon_id (salon_id),
    INDEX idx_phone (phone),
    INDEX idx_email (email)
);
```

**Example Data:**
```
id | salon_id | client_code  | name_en    | name_ar    | phone         | email
1  | 1        | CLI-ABC12345 | John Doe   | جون دو     | +201234567890 | john@...
2  | 1        | CLI-XYZ67890 | Jane Smith | جين سميث   | +201234567891 | jane@...
3  | 1        | CLI-QWE11111 | Ali Ahmed  | علي أحمد    | +201234567892 | NULL
```

---

### books TABLE (Bookings/Appointments)
```sql
CREATE TABLE books (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    salon_id BIGINT UNSIGNED NOT NULL,
    client_id BIGINT UNSIGNED NOT NULL,
    service_id BIGINT UNSIGNED NOT NULL,
    staff_id BIGINT UNSIGNED NOT NULL,
    appointment_datetime DATETIME NOT NULL,
    status ENUM('scheduled', 'completed', 'canceled') DEFAULT 'scheduled',
    price DECIMAL(8, 2) NULL,
    notes TEXT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (salon_id) REFERENCES salons(id) ON DELETE CASCADE,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE,
    
    INDEX idx_salon_appointment (salon_id, appointment_datetime),
    INDEX idx_client_salon (client_id, salon_id),
    INDEX idx_staff_appointment (staff_id, appointment_datetime)
);
```

**Example Data:**
```
id | salon_id | client_id | service_id | staff_id | appointment_datetime | status      | price
1  | 1        | 1         | 1          | 1        | 2026-01-25 14:00:00 | scheduled   | 50.00
2  | 1        | 2         | 2          | 1        | 2026-01-25 15:00:00 | completed   | 25.00
3  | 1        | 3         | 1          | 2        | 2026-01-26 10:00:00 | scheduled   | 50.00
```

---

## Relationships Summary

### Staff ↔ Services (Many-to-Many)
```
Staff 1 can provide Service 1, 2, 3...
Service 1 can be provided by Staff 1, 2, 3...

Pivot table: staff_service
```

### Salon → Bookings ← Client
```
1 Salon has MANY Bookings
1 Client has MANY Bookings
1 Booking = 1 Salon + 1 Client + 1 Service + 1 Staff
```

### Complete Flow
```
Salon
  ├─ Staff Members
  │   └─ Staff ← Provides → Services (via staff_service)
  │
  ├─ Services
  │   └─ Service ← Provided by → Staff
  │
  ├─ Clients
  │   └─ Books Appointments
  │
  └─ Bookings (Appointment)
     = Client + Service + Staff + DateTime
```

---

## Query Examples

### Get Services Provided by Staff 1
```php
$staff = Staff::find(1);
$services = $staff->services;  // All services this staff provides

// SQL: 
// SELECT services.* FROM services
// INNER JOIN staff_service ON services.id = staff_service.service_id
// WHERE staff_service.staff_id = 1
```

### Get All Staff Who Provide Service 1
```php
$service = Service::find(1);
$staff = $service->staff;  // All staff who provide this service

// SQL:
// SELECT staff.* FROM staff
// INNER JOIN staff_service ON staff.id = staff_service.staff_id
// WHERE staff_service.service_id = 1
```

### Get Bookings for Client 1
```php
$client = Client::find(1);
$bookings = $client->bookings;  // All bookings for this client

// SQL:
// SELECT books.* FROM books
// WHERE books.client_id = 1
// ORDER BY appointment_datetime DESC
```

### Get Staff Schedule for a Date
```php
$date = '2026-01-25';
$staff = Staff::find(1);

$bookings = $staff->bookings()
    ->where('salon_id', 1)
    ->whereDate('appointment_datetime', $date)
    ->with('client', 'service')
    ->orderBy('appointment_datetime')
    ->get();

// SQL:
// SELECT books.*, clients.*, services.* FROM books
// INNER JOIN clients ON books.client_id = clients.id
// INNER JOIN services ON books.service_id = services.id
// WHERE books.staff_id = 1 
// AND books.salon_id = 1
// AND DATE(books.appointment_datetime) = '2026-01-25'
// ORDER BY books.appointment_datetime ASC
```

### Check if Staff Provides Service
```php
$provides = $staff->services()
    ->where('service_id', $serviceId)
    ->exists();

// SQL:
// SELECT 1 FROM staff_service
// WHERE staff_id = 1 AND service_id = 1
// LIMIT 1
```

### Find Existing Client
```php
$client = Client::where('salon_id', $salonId)
    ->where('phone', $phone)
    ->first();

// Or use the model method:
$client = Client::findExisting($salonId, $phone, $email);
```

---

## Data Types Reference

| Type | Size | Example |
|------|------|---------|
| BIGINT UNSIGNED | 8 bytes | 1, 100, 9223372036854775807 |
| INT | 4 bytes | 30, 90, 365 |
| VARCHAR(255) | Variable | "Hair Coloring", "صبغ الشعر" |
| TEXT | Variable | Long descriptions |
| DECIMAL(8,2) | 9 bytes | 50.00, 25.50, 1234.99 |
| BOOLEAN | 1 byte | true, false |
| ENUM | Variable | 'scheduled', 'completed', 'canceled' |
| DATETIME | 8 bytes | 2026-01-25 14:00:00 |
| DATE | 3 bytes | 2026-01-25 |
| TIMESTAMP | 4 bytes | Auto updated |

---

## Index Efficiency

### Indexes Created for books Table

1. **idx_salon_appointment** `(salon_id, appointment_datetime)`
   - Fast query: Get all bookings for a salon on a date
   - Usage: Calendar view, daily schedule

2. **idx_client_salon** `(client_id, salon_id)`
   - Fast query: Get all bookings for a client in a salon
   - Usage: Client history, profile view

3. **idx_staff_appointment** `(staff_id, appointment_datetime)`
   - Fast query: Get all bookings for a staff member on a date
   - Usage: Staff schedule, availability check

---

## Constraints & Integrity

### Foreign Keys
- ✓ Salon deleted → All related records deleted
- ✓ Client deleted → Bookings deleted
- ✓ Service deleted → Bookings deleted
- ✓ Staff deleted → Bookings and service assignments deleted

### Unique Constraints
- ✓ client_code: Unique per client
- ✓ staff.email: Unique globally
- ✓ staff_service: Can't assign same service to same staff twice

### NOT NULL Constraints
- ✓ appointment_datetime: Required
- ✓ service_id, staff_id, client_id: Required
- ✓ status: Defaults to 'scheduled'

---

## Migration Execution Log

```
✓ 2026_01_20_191152_create_staff_table ............ 243.07ms
✓ 2026_01_20_191202_create_services_table ........ 71.39ms
✓ 2026_01_20_191218_create_clients_table ......... 10.68ms
✓ 2026_01_20_191251_create_products_table ........ 64.46ms
✓ 2026_01_20_191437_create_books_table ........... 283.45ms
✓ 2026_01_20_192801_create_staff_service_table ... 138.54ms

Total Execution Time: ~811ms
```

All migrations completed successfully! ✓
