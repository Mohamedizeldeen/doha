# Service Filtering - Architecture & Flow Diagrams

## 🏗️ System Architecture

### Data Flow Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                     Database Layer                           │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌──────────┐      ┌──────────┐      ┌──────────────┐       │
│  │  staff   │      │ services │      │ staff_service│       │
│  ├──────────┤      ├──────────┤      ├──────────────┤       │
│  │ id       │      │ id       │◄────►│ staff_id     │       │
│  │ name_ar  │      │ name_ar  │      │ service_id   │       │
│  │ salon_id │      │ price    │      │              │       │
│  │ ...      │      │ ...      │      │ (pivot)      │       │
│  └──────────┘      └──────────┘      └──────────────┘       │
│        ▲                   ▲                                  │
│        │                   │                                  │
│        └───────────────────┘                                 │
│         (Staff has Services)                                 │
│                                                               │
└─────────────────────────────────────────────────────────────┘
         ▲
         │ (Query)
         │
┌─────────────────────────────────────────────────────────────┐
│                  Application Layer                           │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌─────────────────────────────────────────────────────┐   │
│  │           StaffController@getServices()             │   │
│  │  ┌───────────────────────────────────────────────┐  │   │
│  │  │ Returns: staff->services()->get()              │  │   │
│  │  │ Includes: id, name_ar, name_en, price        │  │   │
│  │  └───────────────────────────────────────────────┘  │   │
│  └──────────────────────────┬──────────────────────────┘   │
│                             │                               │
│                    JSON Response                            │
│                             │                               │
│                             ▼                               │
│  ┌─────────────────────────────────────────────────────┐   │
│  │            Routes (API Endpoint)                     │   │
│  │  GET /salon/{salon}/staff/{staff}/services        │   │
│  │  name: staff.services                              │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                               │
└─────────────────────────────────────────────────────────────┘
         ▲
         │ (API Call - optional)
         │
┌─────────────────────────────────────────────────────────────┐
│                  Presentation Layer                          │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌───────────────────────────────────────────────────────┐  │
│  │         Blade Template (Pre-loaded Data)              │  │
│  │                                                        │  │
│  │ allServices = @json($services->map(...))  ┐          │  │
│  │                   staff_ids array           │          │  │
│  │                                             ▼          │  │
│  │  <select id="staff">                  [1, 3, 5]       │  │
│  │  <select id="service" data-staff-ids="[1, 3]">       │  │
│  └───────────────────────────────────────────────────────┘  │
│                             ▲                                │
│                             │                                │
│  ┌──────────────────────────┴────────────────────────────┐  │
│  │          JavaScript Filtering Logic                   │  │
│  │  ┌─────────────────────────────────────────────────┐  │  │
│  │  │ User selects staff                               │  │  │
│  │  │     ↓                                             │  │  │
│  │  │ filterServices() triggered                       │  │  │
│  │  │     ↓                                             │  │  │
│  │  │ Get selectedStaffId from dropdown                │  │  │
│  │  │     ↓                                             │  │  │
│  │  │ Filter: service.staff_ids.includes(staffId)      │  │  │
│  │  │     ↓                                             │  │  │
│  │  │ Show/hide service options                        │  │  │
│  │  │     ↓                                             │  │  │
│  │  │ Clear selection if needed                        │  │  │
│  │  │     ↓                                             │  │  │
│  │  │ Update warning message                           │  │  │
│  │  └─────────────────────────────────────────────────┘  │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

---

## 📊 User Flow Diagram

### Public Booking Form (book.blade.php)

```
START
  │
  ├─► Load page
  │    ├─► All services visible
  │    └─► Warning message visible
  │
  ├─► User selects Staff
  │    ├─► JavaScript event triggered
  │    ├─► Services filtered by staff_ids
  │    └─► Warning message hidden
  │
  ├─► User selects Service
  │    ├─► Validates service is available
  │    └─► Selection maintained
  │
  ├─► User fills Name & Email
  │
  ├─► User selects Date & Time
  │
  ├─► User clicks "Book Appointment Now"
  │    ├─► Validate all required fields
  │    └─► POST /book/{salon} with form data
  │
  └─► Booking created
       └─► Display confirmation
```

### Admin Create Booking Form (booking/create.blade.php)

```
START
  │
  ├─► Login as Admin
  │
  ├─► Navigate to Salon > Bookings > Create
  │    └─► Form loads with all data
  │
  ├─► Select Client
  │
  ├─► Select Staff
  │    ├─► JavaScript event triggered
  │    └─► Services filtered
  │
  ├─► Select Service (from filtered list)
  │
  ├─► Select Date & Time
  │
  ├─► Add Notes (optional)
  │
  ├─► Click "Save Booking"
  │    ├─► Validate relationships
  │    └─► POST /salon/{salon}/booking
  │
  └─► Booking saved
       └─► Redirect to booking details
```

---

## 🔄 Filtering Algorithm Flowchart

```
START: User changes staff selection
  │
  ├─► Read selected staff ID from dropdown
  │
  ├─► Check if staff ID is empty
  │    │
  │    ├─ YES
  │    │   ├─► Show warning message
  │    │   ├─► Hide all services (except empty option)
  │    │   └─► Clear service selection
  │    │       └─► STOP
  │    │
  │    └─ NO
  │        └─► Continue...
  │
  ├─► Hide warning message
  │
  ├─► Get all services array from data
  │
  ├─► Create filtered set of service IDs
  │    │
  │    └─► For each service:
  │        ├─► Check if staff_ids includes selected staff
  │        └─► If yes, add to filtered set
  │
  ├─► Update DOM for each service option
  │    │
  │    └─► For each option:
  │        ├─► If in filtered set → show (hidden = false)
  │        └─► If not in filtered set → hide (hidden = true)
  │
  ├─► Check current service selection
  │    │
  │    ├─► If currently selected service is now hidden
  │    │   └─► Clear selection
  │    │
  │    └─► Else keep selection
  │
  └─► END: Update complete
```

---

## 🏢 Component Interaction

```
┌──────────────────────────────────────────────────┐
│               Booking Form                        │
├──────────────────────────────────────────────────┤
│                                                   │
│  ┌─────────────────────────────────────────────┐ │
│  │          Client Dropdown                    │ │
│  │  (clients from BookingController)           │ │
│  └─────────────────────────────────────────────┘ │
│                                                   │
│  ┌─────────────────────────────────────────────┐ │
│  │       Staff Dropdown (REQUIRED)             │ │
│  │  (all salon staff members)                  │ │
│  │  ┌─────────────────────────────────────┐   │ │
│  │  │ Change Event → filterServices()      │   │ │
│  │  └─────────────────────────────────────┘   │ │
│  └─────────────────────────────────────────────┘ │
│                         │                        │
│                         ▼                        │
│  ┌─────────────────────────────────────────────┐ │
│  │    Service Dropdown (FILTERED)              │ │
│  │  (only staff's services shown)              │ │
│  │                                             │ │
│  │  ┌─────────────────────────────────────┐   │ │
│  │  │ Services Pre-loaded in JavaScript   │   │ │
│  │  │ with staff_ids data attribute       │   │ │
│  │  └─────────────────────────────────────┘   │ │
│  └─────────────────────────────────────────────┘ │
│                                                   │
│  ┌─────────────────────────────────────────────┐ │
│  │         Date & Time Picker                  │ │
│  └─────────────────────────────────────────────┘ │
│                                                   │
│  ┌─────────────────────────────────────────────┐ │
│  │          Notes Field                        │ │
│  └─────────────────────────────────────────────┘ │
│                                                   │
│  ┌─────────────────────────────────────────────┐ │
│  │    [Submit Button] [Cancel Button]          │ │
│  └─────────────────────────────────────────────┘ │
│                                                   │
└──────────────────────────────────────────────────┘
```

---

## 📱 Bilingual Support Flow

```
Page Load
  │
  ├─► Get saved language from localStorage (default: 'ar')
  │
  ├─► switchLanguage(lang) called
  │    ├─► Update HTML dir and lang attributes
  │    ├─► Update CSS classes
  │    └─► Call updateSelectOptions(lang)
  │
  ├─► updateSelectOptions(lang)
  │    │
  │    └─► For each <option> in dropdowns:
  │        ├─► Get data-ar or data-en attribute
  │        └─► Set option.textContent to corresponding language
  │
  ├─► Warning message HTML
  │    │
  │    └─► <span class="hidden-ar">Arabic text</span>
  │        <span class="hidden-en">English text</span>
  │
  ├─► CSS handles visibility
  │    │
  │    └─► html.en .hidden-ar { display: none; }
  │        html.en .hidden-en { display: block; }
  │
  └─► Service filtering still works in both languages
```

---

## 🔐 Security Flow

```
Client Request
  │
  ├─► POST /booking/{store|update}
  │    │
  │    └─► Validate CSRF token
  │
  ├─► Route Handler (BookingController)
  │    │
  │    └─► Check authentication (auth middleware)
  │
  ├─► Authorization Check
  │    │
  │    └─► Verify user owns salon
  │
  ├─► Input Validation
  │    │
  │    ├─► Check client belongs to salon
  │    ├─► Check staff belongs to salon
  │    ├─► Check service belongs to salon
  │    └─► Check all relationships are valid
  │
  ├─► Additional Check (Recommended)
  │    │
  │    └─► Verify staff can provide service
  │        (staff-service relationship exists)
  │
  ├─► Save Booking
  │    │
  │    └─► Database transaction
  │
  └─► Return Success Response
```

---

## 📊 Data Pre-loading

```
Blade Template Execution (Server-side)
  │
  ├─► Query: $services = $salon->services()->get()
  │    └─► Returns all services for salon
  │
  ├─► Query: $staff = $salon->staff()->get()
  │    └─► Returns all staff members
  │
  ├─► For each service:
  │    │
  │    └─► Build array with staff_ids
  │        ├─► services.staff.contains(service)
  │        └─► pluck('id')->toArray()
  │
  ├─► JSON Encode: @json($services->map(...))
  │    │
  │    └─► Creates JavaScript object
  │        [
  │          {id: 1, name_ar: "...", staff_ids: [1,3,5]},
  │          ...
  │        ]
  │
  ├─► Embed in HTML
  │    │
  │    └─► <script>const allServices = {...}</script>
  │
  └─► Client receives pre-loaded data
       └─► No AJAX calls needed during filtering
```

---

## 🎯 State Management

```
Form State During User Interaction

Initial State:
  staff_id = null
  service_id = null
  all_services_visible = true
  warning_visible = true

User selects Staff A (with services 1, 2, 3):
  staff_id = 5
  service_id = null (cleared if was set)
  visible_services = [1, 2, 3]
  warning_visible = false

User selects Service 2:
  staff_id = 5
  service_id = 2
  visible_services = [1, 2, 3]
  warning_visible = false

User changes to Staff B (with services 2, 4):
  staff_id = 8
  service_id = null (cleared because 2 not in [2,4])
  visible_services = [2, 4]
  warning_visible = false

User deselects staff:
  staff_id = null
  service_id = null
  all_services_visible = true
  warning_visible = true
```

---

## 🚀 Performance Optimization

```
Traditional Approach (Would require API):
  Load page
    ↓
  User selects staff
    ↓
  AJAX call to /staff/{id}/services
    ↓
  Wait for response
    ↓
  Update dropdown
    [Slow: API latency 200-500ms]

Our Optimized Approach:
  Load page
    ↓
  Pre-load all services with staff_ids
  [Server generates in one query]
    ↓
  User selects staff
    ↓
  JavaScript filters (no network call)
    ↓
  Instant dropdown update
    [Fast: JavaScript < 10ms]
```

---

## 📝 Summary

This architecture provides:
- ✅ Clean separation of concerns (MVC)
- ✅ Efficient client-side filtering
- ✅ Bilingual support throughout
- ✅ Proper security validation
- ✅ Optimal performance
- ✅ Maintainable code structure
- ✅ Easy to extend for future features

The filtering happens entirely on the client-side using pre-loaded data, making it incredibly fast and responsive while maintaining full bilingual support and security validation on the server.
