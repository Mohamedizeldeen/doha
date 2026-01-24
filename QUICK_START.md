# 🚀 Quick Start Guide - Doha Authentication & Subscription System

## File Structure Overview

```
📦 Doha Project
├── 📁 app/Models/
│   ├── User.php              ✅ Updated with salons() relationship
│   └── Salon.php             ✅ Updated with subscription logic
├── 📁 app/Http/Controllers/
│   ├── AuthController.php    ✅ Login/Register/Logout logic
│   └── SalonController.php   ✅ Salon CRUD + Admin assignment
├── 📁 resources/views/
│   ├── 📁 auth/
│   │   ├── login.blade.php              ✅ Login form (responsive)
│   │   └── register.blade.php           ✅ Registration form (responsive)
│   ├── 📁 salon/
│   │   ├── create.blade.php             ✅ Create salon form (responsive)
│   │   └── index.blade.php              ✅ User's salons dashboard (responsive)
│   └── welcome.blade.php                ✅ Landing page
├── 📁 routes/
│   └── web.php               ✅ All routes configured
├── 📁 database/migrations/
│   └── 2026_01_20_160309_create_salons_table.php ✅ Includes subscription fields
└── AUTH_IMPLEMENTATION.md    📋 Full documentation

```

## 🔧 Installation Steps

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Test the System

#### User Registration:
```
1. Visit: http://localhost:8000/register
2. Fill in: Name, Email, Password (x2)
3. Click: "إنشاء حساب"
4. Automatically logged in & redirected to salon creation
```

#### Create Salon:
```
1. Fill in salon details (English & Arabic)
2. Select subscription type:
   - Trial (14 days free)
   - Monthly ($15)
   - Yearly ($120)
3. Upload logo (optional)
4. Click: "إنشاء الصالون والبدء الآن"
5. Automatically logged in as admin
```

#### Login:
```
1. Visit: http://localhost:8000/login
2. Enter: Email & Password
3. Redirected to: Salon dashboard
4. Shows: All your salons with subscription status
```

#### Logout:
```
1. Click: "تسجيل الخروج" button
2. Session cleared
3. Redirected to: Welcome page
```

## 📊 Database Schema

### salons table:
```
id                          INTEGER (PK)
user_id                     INTEGER (FK) → users.id
name_en                     STRING
name_ar                     STRING
address_en                  STRING (nullable)
address_ar                  STRING (nullable)
phone                       STRING (nullable)
email                       STRING (nullable)
description_en             TEXT (nullable)
description_ar             TEXT (nullable)
logo                        STRING (nullable)
subscription_type          ENUM (trial|monthly|yearly)
subscription_start_date    DATE
subscription_end_date      DATE
trial_end_date            DATE (nullable)
timestamps                 TIMESTAMP
```

## 🔐 Authentication Flow

```
┌─────────────────────────────────────┐
│     USER REGISTRATION               │
├─────────────────────────────────────┤
│ 1. Register with email & password   │
│ 2. User created in DB               │
│ 3. Auto-login                       │
│ 4. Redirect to salon creation       │
└─────────────────────────────────────┘
           ↓
┌─────────────────────────────────────┐
│     SALON CREATION                  │
├─────────────────────────────────────┤
│ 1. Create salon details             │
│ 2. Select subscription type         │
│ 3. Dates auto-calculated:           │
│    - Trial: +14 days                │
│    - Monthly: +30 days              │
│    - Yearly: +365 days              │
│ 4. User = ADMIN (default)           │
│ 5. Redirect to dashboard            │
└─────────────────────────────────────┘
           ↓
┌─────────────────────────────────────┐
│     LOGIN (RETURNING USER)          │
├─────────────────────────────────────┤
│ 1. Email & password                 │
│ 2. Check subscription status        │
│ 3. If expired → Show upgrade        │
│ 4. If active → Dashboard            │
│ 5. Multiple salons supported        │
└─────────────────────────────────────┘
           ↓
┌─────────────────────────────────────┐
│     SALON DASHBOARD                 │
├─────────────────────────────────────┤
│ 1. View all user salons             │
│ 2. Show subscription status         │
│ 3. Days remaining counter           │
│ 4. Create/Edit/Delete options       │
│ 5. Logout button                    │
└─────────────────────────────────────┘
```

## 🎯 Key Features

### ✅ Subscription Management
- **Trial**: 14 days free (automatically calculated)
- **Monthly**: $15 per month (30 days)
- **Yearly**: $120 per year (365 days)
- Automatic date calculation via `setSubscriptionDates()`
- Status checking with `isSubscriptionActive()`
- Trial expiration detection with `isTrialExpired()`
- Days remaining counter with `daysRemaining()`

### ✅ Admin Assignment
- New user automatically becomes admin of their salon
- Via `user_id` foreign key relationship
- Can create multiple salons (multiple admin roles)
- Full authorization checks in place

### ✅ Multi-Language Support
- English & Arabic fields for all content
- RTL support for Arabic layout
- Cairo font for proper Arabic rendering

### ✅ Security
- Password hashing (bcrypt)
- CSRF protection
- Session management
- Authorization checks
- Input validation

### ✅ Responsive Design
- Mobile-first approach
- Scales from 320px → 1280px+
- Tailwind CSS responsive classes
- Touch-friendly buttons and forms

## 📝 Routes Reference

### Public Routes:
```
GET  /                    → Welcome page
GET  /login              → Login form
POST /login              → Login handler
GET  /register           → Registration form
POST /register           → Registration handler
```

### Protected Routes:
```
GET  /salons             → User's salons (index)
GET  /salon/create       → Create salon form
POST /salon              → Store salon
GET  /salon/{id}         → View salon
GET  /salon/{id}/edit    → Edit salon form
PUT  /salon/{id}         → Update salon
DELETE /salon/{id}       → Delete salon
POST /logout             → Logout handler
```

## 🧪 Testing Scenarios

### Scenario 1: New User Journey
```
1. Register with new email
2. Should redirect to salon creation
3. Create salon with Trial subscription
4. Should see 14-day trial period
5. Admin role assigned automatically
```

### Scenario 2: Subscription Types
```
Create 3 salons with different types:
1. Trial → subscription_end_date = today + 14 days
2. Monthly → subscription_end_date = today + 30 days
3. Yearly → subscription_end_date = today + 365 days
```

### Scenario 3: Trial Expiration
```
1. Create salon with trial
2. Manually set subscription_end_date to past date
3. Login
4. Should show "upgrade required" message
5. Can still view but can't use features
```

### Scenario 4: Multiple Salons
```
1. Create 3 salons
2. Visit /salons
3. Should show all 3 with their statuses
4. User is admin of all 3
5. Can manage each independently
```

## 🐛 Troubleshooting

### Issue: "Column not found" error
- Run: `php artisan migrate`
- Check database connection in `.env`

### Issue: Logo not uploading
- Ensure: `storage/app/public` directory exists
- Run: `php artisan storage:link`
- Check: `config/filesystems.php` settings

### Issue: Can't login after registration
- Check: Session is being saved
- Verify: Database has user record
- Check: Password hashing is working

### Issue: Subscription dates wrong
- Verify: `setSubscriptionDates()` is called before save
- Check: `Carbon` library is imported
- Ensure: Database date format is correct

## 📚 Code Examples

### Check if subscription is active:
```php
$salon = Salon::find(1);
if ($salon->isSubscriptionActive()) {
    // Allow access
} else {
    // Show upgrade page
}
```

### Get days remaining:
```php
$remaining = $salon->daysRemaining();
echo "Days left: " . $remaining; // Output: "Days left: 10"
```

### Check if trial expired:
```php
if ($salon->isTrialExpired()) {
    // Show upgrade prompt
}
```

### Create new salon with dates:
```php
$salon = new Salon([
    'user_id' => Auth::id(),
    'name_en' => 'My Salon',
    'name_ar' => 'صالوني',
    'subscription_type' => 'trial'
]);
$salon->setSubscriptionDates();
$salon->save();
```

## 🎨 Design Features

- **Gradient Colors**: Pink/Magenta (#dd208e to #b01670)
- **Responsive**: Mobile, Tablet, Desktop optimized
- **Cairo Font**: Proper Arabic typography
- **RTL Support**: Full right-to-left layout
- **Smooth Transitions**: Hover effects & animations
- **Accessibility**: Proper labels, ARIA attributes

## 📞 Support

For issues or questions, check:
1. `AUTH_IMPLEMENTATION.md` - Full documentation
2. Database logs - Check for SQL errors
3. Laravel logs - `storage/logs/laravel.log`
4. Console - Check browser developer tools

---

**Last Updated**: 2026-01-20
**Version**: 1.0
