<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" id="htmlElement">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('booking.page_title') }} - {{ $company ?? __('booking.default_salon') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        :root {
            --accent: #dd208e;
            --accent-dark: #b01670;
            --accent-light: #fdf2f8;
            --accent-glow: rgba(221,32,142,0.12);
            --bg: #f4f6fb;
            --card: #ffffff;
            --text: #1a1d2e;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --radius: 16px;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.06);
            --shadow-lg: 0 12px 32px rgba(0,0,0,0.08);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Cairo', 'Inter'" : "'Inter', 'Cairo'" }}, system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
            line-height: 1.6;
        }
        .ltr { direction: ltr; }

        /* Subtle background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse at 10% 10%, rgba(221,32,142,0.03) 0%, transparent 60%),
                radial-gradient(ellipse at 90% 90%, rgba(99,102,241,0.03) 0%, transparent 60%);
            pointer-events: none;
        }

        /* Top accent bar */
        .top-bar {
            height: 3px;
            background: linear-gradient(90deg, var(--accent), #8b5cf6, var(--accent));
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        /* Page layout */
        .page-wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .page-header {
            background: var(--card);
            border-bottom: 1px solid var(--border);
            padding: 0.875rem 0;
            position: sticky;
            top: 3px;
            z-index: 50;
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.95);
        }
        .header-inner {
            max-width: 960px;
            margin: 0 auto;
            padding: 0 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .salon-brand { display: flex; align-items: center; gap: 0.75rem; }
        .salon-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            object-fit: contain;
            background: var(--accent-light);
            padding: 3px;
            border: 1px solid rgba(221,32,142,0.1);
        }
        .salon-title { font-weight: 800; font-size: 1.05rem; color: var(--text); letter-spacing: -0.01em; }
        .salon-subtitle { font-size: 0.7rem; color: var(--text-muted); font-weight: 500; margin-top: 1px; }

        .lang-toggle {
            display: flex;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            background: #f9fafb;
        }
        .lang-btn {
            padding: 0.35rem 0.85rem;
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: inherit;
        }
        .lang-btn.active {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 2px 8px rgba(221,32,142,0.25);
        }

        /* Main content */
        .main-content {
            max-width: 960px;
            margin: 0 auto;
            padding: 1.5rem 1.25rem 2.5rem;
            flex: 1;
            width: 100%;
        }

        /* Step progress bar */
        .steps-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: 1.75rem;
            background: var(--card);
            padding: 0.625rem 1.25rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }
        .step-pill {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 0.9rem;
            border-radius: 10px;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-muted);
            transition: all 0.3s ease;
            cursor: default;
            white-space: nowrap;
        }
        .step-pill .step-num {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 800;
            background: #f1f5f9;
            color: var(--text-muted);
            transition: all 0.3s;
            flex-shrink: 0;
        }
        .step-pill.active { background: var(--accent-light); color: var(--accent); }
        .step-pill.active .step-num {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 3px 10px rgba(221,32,142,0.3);
        }
        .step-pill.done { color: #059669; }
        .step-pill.done .step-num { background: #dcfce7; color: #059669; }
        .step-connector {
            width: 28px;
            height: 2px;
            background: var(--border);
            flex-shrink: 0;
            margin: 0 0.15rem;
            border-radius: 2px;
            transition: background 0.3s;
        }
        .step-connector.done { background: #86efac; }

        /* Cards */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .card-body { padding: 1.75rem; }
        .card-header-bar {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .card-header-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #fff;
            flex-shrink: 0;
        }

        /* Section titles */
        .section-title { font-size: 1rem; font-weight: 800; color: var(--text); letter-spacing: -0.01em; }
        .section-desc { font-size: 0.75rem; color: var(--text-muted); margin-top: 2px; }

        /* Step panels */
        .step-panel { display: none; animation: fadeSlide 0.35s ease forwards; }
        .step-panel.active { display: block; }
        @keyframes fadeSlide { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Form inputs */
        .form-group { margin-bottom: 1.125rem; }
        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .form-input {
            width: 100%;
            padding: 0.7rem 0.9rem;
            background: #f9fafb;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-size: 0.875rem;
            transition: all 0.2s ease;
            outline: none;
            font-family: inherit;
        }
        .form-input::placeholder { color: #9ca3af; }
        .form-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
            background: #fff;
        }

        /* Staff cards */
        .staff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 0.625rem;
        }
        .staff-card {
            background: #f9fafb;
            border: 2px solid transparent;
            border-radius: 14px;
            padding: 1rem 0.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }
        .staff-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: rgba(221,32,142,0.15);
        }
        .staff-card.selected {
            border-color: var(--accent);
            background: var(--accent-light);
            box-shadow: 0 4px 12px rgba(221,32,142,0.12);
        }
        .staff-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-size: 1.1rem;
            color: #fff;
            font-weight: 800;
            transition: box-shadow 0.2s;
        }
        .staff-card.selected .staff-avatar { box-shadow: 0 4px 14px rgba(221,32,142,0.3); }
        .staff-card .staff-avail-dot { display: none; width: 8px; height: 8px; border-radius: 50%; margin: 0.25rem auto 0; }
        .staff-card .staff-avail-dot.show { display: block; }
        .staff-card .staff-avail-dot.free { background: #22c55e; box-shadow: 0 0 6px rgba(34,197,94,0.4); }
        .staff-card .staff-avail-dot.busy { background: #ef4444; box-shadow: 0 0 6px rgba(239,68,68,0.4); }
        .staff-card.staff-busy { opacity: 0.4; }
        .staff-card.staff-busy:hover { transform: none; box-shadow: none; }

        /* Service cards */
        .service-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }
        .service-card {
            background: #f9fafb;
            border: 2px solid transparent;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }
        .service-card:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
            border-color: rgba(221,32,142,0.15);
        }
        .service-card.selected {
            border-color: var(--accent);
            background: var(--accent-light);
        }
        .service-card.selected::before {
            content: '';
            position: absolute;
            top: 0;
            {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 0;
            width: 3px;
            height: 100%;
            background: var(--accent);
            border-radius: {{ app()->getLocale() === 'ar' ? '0 6px 6px 0' : '6px 0 0 6px' }};
        }
        .service-card .service-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }
        .service-name { font-weight: 700; font-size: 0.85rem; color: var(--text); }
        .service-duration { font-size: 0.72rem; color: var(--text-muted); margin-top: 2px; }
        .service-price {
            font-weight: 800;
            color: var(--accent);
            font-size: 0.85rem;
            white-space: nowrap;
            background: var(--accent-light);
            padding: 0.25rem 0.65rem;
            border-radius: 8px;
            flex-shrink: 0;
        }
        .service-check {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s;
            font-size: 0.6rem;
            color: transparent;
        }
        .service-card.selected .service-check {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        /* Time slots */
        .time-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(72px, 1fr));
            gap: 0.4rem;
        }
        .time-slot {
            padding: 0.55rem 0.25rem;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
            text-align: center;
            font-weight: 600;
            font-size: 0.8rem;
            background: #f9fafb;
            color: var(--text);
        }
        .time-slot:hover:not(.disabled) {
            border-color: var(--accent);
            background: var(--accent-light);
            color: var(--accent);
        }
        .time-slot.selected {
            border-color: var(--accent);
            background: var(--accent);
            color: #fff;
            box-shadow: 0 3px 10px rgba(221,32,142,0.25);
        }
        .time-slot.disabled { opacity: 0.3; cursor: not-allowed; text-decoration: line-through; }

        /* Buttons */
        .btn {
            padding: 0.65rem 1.5rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            font-family: inherit;
        }
        .btn-primary {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 3px 12px rgba(221,32,142,0.25);
        }
        .btn-primary:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
            box-shadow: 0 5px 18px rgba(221,32,142,0.3);
        }
        .btn-back {
            background: #f1f5f9;
            color: var(--text-muted);
        }
        .btn-back:hover { background: #e2e8f0; color: var(--text); }
        .btn-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid #f1f5f9;
        }

        /* Summary */
        .summary-card-inner {
            background: #f9fafb;
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            border: 1px solid var(--border);
        }
        .summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.7rem 0;
            border-bottom: 1px solid #f1f5f9;
            gap: 1rem;
        }
        .summary-row:last-child { border-bottom: none; }
        .summary-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.82rem;
            color: var(--text-muted);
            flex-shrink: 0;
        }
        .summary-label i { color: var(--accent); width: 16px; text-align: center; font-size: 0.75rem; }
        .summary-value { font-weight: 700; font-size: 0.85rem; text-align: end; }

        /* Success */
        .success-card {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1px solid #bbf7d0;
            border-radius: var(--radius);
            padding: 2rem;
            text-align: center;
        }
        .success-icon { width: 60px; height: 60px; border-radius: 50%; background: #16a34a; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
        .success-icon i { color: #fff; font-size: 1.4rem; }

        /* Flatpickr overrides */
        .flatpickr-calendar {
            border-radius: 14px !important;
            border: 1px solid var(--border) !important;
            box-shadow: var(--shadow-lg) !important;
            font-family: inherit !important;
        }
        .flatpickr-day.selected { background: var(--accent) !important; border-color: var(--accent) !important; }
        .flatpickr-day:hover { background: var(--accent-light) !important; border-color: var(--accent) !important; }
        .flatpickr-months .flatpickr-month { height: 36px !important; }

        /* Info section */
        .info-section {
            margin-top: 3.5rem;
            padding-top: 2.5rem;
            border-top: 2px solid var(--border);
        }
        .info-section-title {
            text-align: center;
            margin-bottom: 2rem;
        }
        .info-section-title h2 {
            font-size: 1.35rem;
            font-weight: 900;
            color: var(--text);
            letter-spacing: -0.02em;
        }
        .info-section-title p {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 0.35rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            align-items: start;
        }
        .info-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .info-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        .info-card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }
        .info-card-header .icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #fff;
            font-size: 0.9rem;
        }
        .info-card-header h3 {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--text);
        }

        /* Working hours rows */
        .hours-list { flex: 1; }
        .hours-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 0.75rem;
            border-radius: 8px;
            transition: background 0.15s;
        }
        .hours-row:nth-child(odd) { background: #f9fafb; }
        .hours-row:hover { background: var(--accent-light); }
        .hours-day {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
        }
        .hours-time {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--accent);
            background: var(--accent-light);
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            direction: ltr;
        }

        /* Feature list */
        .feature-list { flex: 1; display: flex; flex-direction: column; gap: 0.5rem; }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.75rem;
            background: #f9fafb;
            border-radius: 10px;
            transition: all 0.2s;
        }
        .feature-item:hover { background: var(--accent-light); }
        .feature-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #e44d9e);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .feature-icon i { color: #fff; font-size: 0.6rem; }
        .feature-text { font-size: 0.82rem; font-weight: 600; color: var(--text); }

        /* Contact items */
        .contact-list { flex: 1; display: flex; flex-direction: column; gap: 0.625rem; }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.7rem 0.75rem;
            background: #f9fafb;
            border-radius: 10px;
            transition: all 0.2s;
        }
        .contact-item:hover { background: var(--accent-light); }
        .contact-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--accent-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s;
        }
        .contact-item:hover .contact-icon { background: var(--accent); }
        .contact-icon i { color: var(--accent); font-size: 0.8rem; transition: color 0.2s; }
        .contact-item:hover .contact-icon i { color: #fff; }
        .contact-text {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text);
        }

        /* Product Cards */
        .products-section {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 2px solid var(--border);
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.25rem;
        }
        .product-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }
        .product-img-wrap {
            position: relative;
            height: 180px;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            overflow: hidden;
        }
        .product-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s; }
        .product-card:hover .product-img-wrap img { transform: scale(1.05); }
        .product-badge {
            position: absolute;
            top: 0.75rem;
            padding: 0.3rem 0.7rem;
            border-radius: 8px;
            font-size: 0.72rem;
            font-weight: 700;
            color: #fff;
        }
        .product-badge-price {
            bottom: 0.75rem;
            top: auto;
            background: var(--accent);
            font-weight: 800;
            font-size: 0.82rem;
            padding: 0.35rem 0.85rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(221,32,142,0.3);
        }
        .product-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .product-body h3 { font-size: 0.95rem; font-weight: 800; color: var(--text); margin-bottom: 0.25rem; }
        .product-body .product-desc {
            font-size: 0.78rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 0.75rem;
            flex: 1;
        }
        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 0.75rem;
            border-top: 1px solid #f1f5f9;
        }
        .stock-label { font-size: 0.75rem; color: var(--text-muted); font-weight: 500; }
        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.6rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .stock-badge.in-stock { background: #dcfce7; color: #16a34a; }
        .stock-badge.out-stock { background: #fee2e2; color: #ef4444; }

        /* Footer */
        .page-footer {
            border-top: 1px solid var(--border);
            padding: 1.25rem;
            text-align: center;
            background: var(--card);
            margin-top: auto;
        }
        .page-footer p { font-size: 0.75rem; color: var(--text-muted); }

        /* Bilingual text helpers */
        .hidden-en { display: none; }
        html.en .hidden-ar { display: none !important; }
        html.en .hidden-en { display: block !important; display: inline !important; }

        @keyframes checkPop { 0% { transform: scale(0); } 60% { transform: scale(1.2); } 100% { transform: scale(1); } }
        .check-pop { animation: checkPop 0.6s cubic-bezier(0.4,0,0.2,1) forwards; }

        /* Date/time layout */
        .datetime-grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 1.5rem; }
        .datetime-section-label {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.5rem;
        }
        .datetime-section-label i { color: var(--accent); font-size: 0.7rem; }

        /* Responsive */
        @media (max-width: 768px) {
            .info-grid { grid-template-columns: 1fr; gap: 1rem; }
            .datetime-grid { grid-template-columns: 1fr; }
            .service-grid { grid-template-columns: 1fr; }
            .staff-grid { grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); }
            .main-content { padding: 1.25rem 1rem 2rem; }
        }
        @media (max-width: 480px) {
            .step-pill span:not(.step-num) { display: none; }
            .step-connector { width: 16px; }
            .steps-bar { padding: 0.5rem 0.75rem; }
            .step-pill { padding: 0.35rem 0.5rem; }
            .card-body { padding: 1.25rem; }
            .staff-grid { grid-template-columns: repeat(3, 1fr); }
            .header-inner { padding: 0 0.875rem; }
            .product-grid { grid-template-columns: 1fr; }
            .product-img-wrap { height: 160px; }
        }
    </style>
</head>
<body>
    <div class="top-bar"></div>

    <div class="page-wrapper">
        {{-- Header --}}
        <header class="page-header">
            <div class="header-inner">
                <div class="salon-brand">
                    @if($salon->logo)
                    <img src="{{ asset('storage/' . $salon->logo) }}" alt="{{ $salon->name_ar }}" class="salon-logo">
                    @else
                    <div class="salon-logo" style="background: var(--accent); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-spa text-white"></i>
                    </div>
                    @endif
                    <div>
                        <div class="salon-title">
                            <span class="hidden-ar">{{ $salon->name_ar }}</span>
                            <span class="hidden-en">{{ $salon->name_en ?? $salon->name_ar }}</span>
                        </div>
                        <div class="salon-subtitle">
                            <span class="hidden-ar">{{ __('booking.book_title', [], 'ar') }}</span>
                            <span class="hidden-en">{{ __('booking.book_title', [], 'en') }}</span>
                        </div>
                    </div>
                </div>
                <div class="lang-toggle">
                    <button class="lang-btn active" onclick="switchLanguage('ar')">عربي</button>
                    <button class="lang-btn" onclick="switchLanguage('en')">EN</button>
                </div>
            </div>
        </header>

        <div class="main-content">
            {{-- Success Message --}}
            @if (session('success'))
            <div class="success-card mb-8 max-w-xl mx-auto">
                <div class="success-icon check-pop"><i class="fas fa-check"></i></div>
                <p class="text-lg font-bold text-green-700 success-title" data-ar="{{ __('booking.success_message', [], 'ar') }}" data-en="{{ __('booking.success_message', [], 'en') }}">{{ __('booking.success_message') }}</p>
            </div>
            @endif

            {{-- Step Progress --}}
            <div class="steps-bar" id="stepProgress">
                <div class="step-pill active" data-step="1">
                    <span class="step-num">1</span>
                    <span>
                        <span class="hidden-ar">{{ __('booking.customer_info', [], 'ar') }}</span>
                        <span class="hidden-en">{{ __('booking.customer_info', [], 'en') }}</span>
                    </span>
                </div>
                <div class="step-connector" data-after="1"></div>
                <div class="step-pill" data-step="2">
                    <span class="step-num">2</span>
                    <span>
                        <span class="hidden-ar">{{ __('booking.select_service_staff', [], 'ar') }}</span>
                        <span class="hidden-en">{{ __('booking.select_service_staff', [], 'en') }}</span>
                    </span>
                </div>
                <div class="step-connector" data-after="2"></div>
                <div class="step-pill" data-step="3">
                    <span class="step-num">3</span>
                    <span>
                        <span class="hidden-ar">{{ __('booking.select_datetime', [], 'ar') }}</span>
                        <span class="hidden-en">{{ __('booking.select_datetime', [], 'en') }}</span>
                    </span>
                </div>
                <div class="step-connector" data-after="3"></div>
                <div class="step-pill" data-step="4">
                    <span class="step-num">4</span>
                    <span>
                        <span class="hidden-ar">تأكيد</span>
                        <span class="hidden-en">Confirm</span>
                    </span>
                </div>
            </div>

            <form method="POST" action="{{ route('booking.public.store', $company) }}" id="bookingForm">
                @csrf

                {{-- STEP 1: Customer Info --}}
                <div class="step-panel active" data-panel="1">
                    <div class="card max-w-lg mx-auto">
                        <div class="card-body">
                            <div class="card-header-bar">
                                <div class="card-header-icon" style="background: linear-gradient(135deg, var(--accent), #e44d9e);">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h2 class="section-title">
                                        <span class="hidden-ar">{{ __('booking.customer_info', [], 'ar') }}</span>
                                        <span class="hidden-en">{{ __('booking.customer_info', [], 'en') }}</span>
                                    </h2>
                                    <p class="section-desc">
                                        <span class="hidden-ar">أدخل معلوماتك للحجز</span>
                                        <span class="hidden-en">Enter your details to book</span>
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <span class="hidden-ar">{{ __('booking.full_name', [], 'ar') }}</span>
                                    <span class="hidden-en">{{ __('booking.full_name', [], 'en') }}</span>
                                </label>
                                <input type="text" id="name" name="name" required class="form-input"
                                    placeholder="{{ __('booking.name_placeholder') }}" data-en-placeholder="{{ __('booking.name_placeholder', [], 'en') }}" data-ar-placeholder="{{ __('booking.name_placeholder', [], 'ar') }}">
                                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span class="hidden-ar">{{ __('booking.phone', [], 'ar') }}</span>
                                        <span class="hidden-en">{{ __('booking.phone', [], 'en') }}</span>
                                    </label>
                                    <input type="tel" id="phone" name="phone" required class="form-input ltr"
                                        placeholder="+966 50 0000000">
                                    @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">
                                        <span class="hidden-ar">{{ __('booking.email', [], 'ar') }}</span>
                                        <span class="hidden-en">{{ __('booking.email', [], 'en') }}</span>
                                    </label>
                                    <input type="email" id="email" name="email" class="form-input ltr"
                                        placeholder="{{ __('booking.email_placeholder') }}" data-en-placeholder="{{ __('booking.email_placeholder', [], 'en') }}" data-ar-placeholder="{{ __('booking.email_placeholder', [], 'ar') }}">
                                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="btn-actions">
                                <div></div>
                                <button type="button" class="btn btn-primary" onclick="goToStep(2)">
                                    <span class="hidden-ar">التالي</span>
                                    <span class="hidden-en">Next</span>
                                    <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 2: Service & Staff --}}
                <div class="step-panel" data-panel="2">
                    <div class="card max-w-3xl mx-auto">
                        <div class="card-body">
                            {{-- Staff --}}
                            <div class="mb-6">
                                <div class="card-header-bar" style="margin-bottom: 1rem;">
                                    <div class="card-header-icon" style="background: linear-gradient(135deg, #3b82f6, #6366f1);">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <div>
                                        <h2 class="section-title">
                                            <span class="hidden-ar">{{ __('booking.staff_label', [], 'ar') }}</span>
                                            <span class="hidden-en">{{ __('booking.staff_label', [], 'en') }}</span>
                                        </h2>
                                        <p class="section-desc">
                                            <span class="hidden-ar">اختر الموظف المفضل أو أي متاح</span>
                                            <span class="hidden-en">Choose preferred staff or any available</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="staff-grid" id="staffGrid">
                                    <div class="staff-card selected" data-staff-id="" onclick="selectStaff(this, '')">
                                        <div class="staff-avatar" style="background: linear-gradient(135deg, #64748b, #475569);"><i class="fas fa-users" style="font-size:0.9rem;"></i></div>
                                        <p class="font-bold text-xs staff-name" data-ar="{{ __('booking.any_available_staff', [], 'ar') }}" data-en="{{ __('booking.any_available_staff', [], 'en') }}">{{ __('booking.any_available_staff') }}</p>
                                        <div class="staff-avail-dot"></div>
                                    </div>
                                    @foreach($staff as $member)
                                    <div class="staff-card" data-staff-id="{{ $member->id }}" onclick="selectStaff(this, '{{ $member->id }}')">
                                        <div class="staff-avatar">{{ mb_substr($member->name_ar, 0, 1) }}</div>
                                        <p class="font-bold text-xs staff-name" data-ar="{{ $member->name_ar }}" data-en="{{ $member->name_en ?? $member->name_ar }}">{{ app()->getLocale() === 'ar' ? $member->name_ar : ($member->name_en ?? $member->name_ar) }}</p>
                                        <div class="staff-avail-dot"></div>
                                    </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="staff_id" id="staffInput" value="">
                            </div>

                            {{-- Service --}}
                            <div>
                                <div class="card-header-bar" style="margin-bottom: 1rem;">
                                    <div class="card-header-icon" style="background: linear-gradient(135deg, var(--accent), #e44d9e);">
                                        <i class="fas fa-spa"></i>
                                    </div>
                                    <div>
                                        <h2 class="section-title">
                                            <span class="hidden-ar">{{ __('booking.required_service', [], 'ar') }}</span>
                                            <span class="hidden-en">{{ __('booking.required_service', [], 'en') }}</span>
                                        </h2>
                                        <p class="section-desc">
                                            <span class="hidden-ar">اختر الخدمة المطلوبة</span>
                                            <span class="hidden-en">Select the service you need</span>
                                        </p>
                                    </div>
                                </div>
                                @php
                                    $serviceStaffData = [];
                                    foreach($services as $svc) {
                                        $serviceStaffData[$svc->id] = $svc->staff->pluck('id')->toArray();
                                    }
                                @endphp
                                <div class="service-grid" id="serviceGrid">
                                    @foreach($services as $service)
                                    <div class="service-card" data-service-id="{{ $service->id }}" data-staff-ids="{{ json_encode($serviceStaffData[$service->id]) }}" data-price="{{ $service->price }}" onclick="selectService(this, '{{ $service->id }}')">
                                        <div class="service-inner">
                                            <div class="service-check"><i class="fas fa-check"></i></div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="service-name" data-ar="{{ $service->name_ar }}" data-en="{{ $service->name_en ?? $service->name_ar }}">{{ app()->getLocale() === 'ar' ? $service->name_ar : ($service->name_en ?? $service->name_ar) }}</h3>
                                                @if($service->duration)
                                                <p class="service-duration"><i class="fas fa-clock" style="margin-inline-end: 4px;"></i>{{ $service->duration }} min</p>
                                                @endif
                                            </div>
                                            <span class="service-price">{{ $service->price }} {{ $salon->currency }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="service_id" id="serviceInput" value="" required>
                                @error('service_id') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="btn-actions">
                                <button type="button" class="btn btn-back" onclick="goToStep(1)">
                                    <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
                                    <span class="hidden-ar">السابق</span>
                                    <span class="hidden-en">Back</span>
                                </button>
                                <button type="button" class="btn btn-primary" onclick="goToStep(3)" id="step2Next">
                                    <span class="hidden-ar">التالي</span>
                                    <span class="hidden-en">Next</span>
                                    <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 3: Date & Time --}}
                <div class="step-panel" data-panel="3">
                    <div class="card max-w-3xl mx-auto">
                        <div class="card-body">
                            <div class="card-header-bar">
                                <div class="card-header-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <h2 class="section-title">
                                        <span class="hidden-ar">{{ __('booking.select_datetime', [], 'ar') }}</span>
                                        <span class="hidden-en">{{ __('booking.select_datetime', [], 'en') }}</span>
                                    </h2>
                                    <p class="section-desc">
                                        <span class="hidden-ar">حدد التاريخ والوقت المناسب</span>
                                        <span class="hidden-en">Pick a date and time that works for you</span>
                                    </p>
                                </div>
                            </div>

                            <div class="datetime-grid">
                                <div>
                                    <label class="datetime-section-label">
                                        <i class="fas fa-calendar"></i>
                                        <span class="hidden-ar">{{ __('booking.date', [], 'ar') }}</span>
                                        <span class="hidden-en">{{ __('booking.date', [], 'en') }}</span>
                                    </label>
                                    <input type="date" id="date" name="appointment_date" required class="form-input ltr" min="{{ date('Y-m-d') }}">
                                    @error('appointment_date') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="datetime-section-label">
                                        <i class="fas fa-clock"></i>
                                        <span class="hidden-ar">{{ __('booking.time', [], 'ar') }}</span>
                                        <span class="hidden-en">{{ __('booking.time', [], 'en') }}</span>
                                    </label>
                                    <div class="time-grid" id="timeSlotsGrid">
                                        <p class="col-span-full text-center py-6" style="color: var(--text-muted); font-size: 0.82rem;">
                                            <i class="fas fa-calendar-day" style="margin-inline-end: 4px;"></i>
                                            <span class="hidden-ar">اختر التاريخ أولاً</span>
                                            <span class="hidden-en">Select a date first</span>
                                        </p>
                                    </div>
                                    <input type="hidden" name="appointment_time" id="timeInput" value="" required>
                                    @error('appointment_time') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="btn-actions">
                                <button type="button" class="btn btn-back" onclick="goToStep(2)">
                                    <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
                                    <span class="hidden-ar">السابق</span>
                                    <span class="hidden-en">Back</span>
                                </button>
                                <button type="button" class="btn btn-primary" onclick="goToStep(4)" id="step3Next">
                                    <span class="hidden-ar">التالي</span>
                                    <span class="hidden-en">Next</span>
                                    <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 4: Confirm --}}
                <div class="step-panel" data-panel="4">
                    <div class="card max-w-lg mx-auto">
                        <div class="card-body">
                            <div class="card-header-bar">
                                <div class="card-header-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <div>
                                    <h2 class="section-title">
                                        <span class="hidden-ar">تأكيد الحجز</span>
                                        <span class="hidden-en">Confirm Booking</span>
                                    </h2>
                                    <p class="section-desc">
                                        <span class="hidden-ar">راجع تفاصيل حجزك</span>
                                        <span class="hidden-en">Review your booking details</span>
                                    </p>
                                </div>
                            </div>

                            <div class="summary-card-inner" id="summaryCard">
                                {{-- Filled by JS --}}
                            </div>

                            <div class="btn-actions">
                                <button type="button" class="btn btn-back" onclick="goToStep(3)">
                                    <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
                                    <span class="hidden-ar">السابق</span>
                                    <span class="hidden-en">Back</span>
                                </button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-check-circle"></i>
                                    <span class="hidden-ar">{{ __('booking.book_now', [], 'ar') }}</span>
                                    <span class="hidden-en">{{ __('booking.book_now', [], 'en') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Salon Info --}}
            <div class="info-section">
                <div class="info-section-title">
                    <h2>
                        <span class="hidden-ar">معلومات الصالون</span>
                        <span class="hidden-en">Salon Information</span>
                    </h2>
                    <p>
                        <span class="hidden-ar">تعرف على المزيد عنا</span>
                        <span class="hidden-en">Learn more about us</span>
                    </p>
                </div>

                <div class="info-grid">
                    {{-- Working Hours --}}
                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="icon-circle" style="background: linear-gradient(135deg, #3b82f6, #6366f1);">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3>
                                <span class="hidden-ar">{{ __('booking.working_hours', [], 'ar') }}</span>
                                <span class="hidden-en">{{ __('booking.working_hours', [], 'en') }}</span>
                            </h3>
                        </div>
                        @php
                            $workDays = is_string($salon->work_days) ? json_decode($salon->work_days, true) : $salon->work_days;
                            $dayTranslations = [
                                'Sunday' => 'الأحد', 'Monday' => 'الإثنين', 'Tuesday' => 'الثلاثاء',
                                'Wednesday' => 'الأربعاء', 'Thursday' => 'الخميس', 'Friday' => 'الجمعة', 'Saturday' => 'السبت'
                            ];
                        @endphp
                        <div class="hours-list">
                            @foreach($workDays as $day)
                            <div class="hours-row">
                                <span class="hours-day">
                                    <span class="hidden-ar">{{ $dayTranslations[$day] ?? $day }}</span>
                                    <span class="hidden-en">{{ $day }}</span>
                                </span>
                                <span class="hours-time">{{ date('g:i A', strtotime($salon->opening_time)) }} - {{ date('g:i A', strtotime($salon->closing_time)) }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Why Choose Us --}}
                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="icon-circle" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                <i class="fas fa-star"></i>
                            </div>
                            <h3>
                                <span class="hidden-ar">{{ __('booking.why_choose_us', [], 'ar') }}</span>
                                <span class="hidden-en">{{ __('booking.why_choose_us', [], 'en') }}</span>
                            </h3>
                        </div>
                        @php $features = ['excellent_service', 'high_quality', 'professional_staff', 'competitive_prices']; @endphp
                        <div class="feature-list">
                            @foreach($features as $f)
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="feature-text">
                                    <span class="hidden-ar">{{ __('booking.'.$f, [], 'ar') }}</span>
                                    <span class="hidden-en">{{ __('booking.'.$f, [], 'en') }}</span>
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Contact --}}
                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="icon-circle" style="background: linear-gradient(135deg, #10b981, #059669);">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h3>
                                <span class="hidden-ar">تواصل معنا</span>
                                <span class="hidden-en">Contact Us</span>
                            </h3>
                        </div>
                        <div class="contact-list">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <span class="contact-text ltr">{{ $salon->phone }}</span>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <span class="contact-text ltr" style="font-size: 0.8rem;">{{ $salon->email }}</span>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <span class="contact-text">
                                    <span class="hidden-ar">{{ $salon->address_ar }}</span>
                                    <span class="hidden-en">{{ $salon->address_en ?? $salon->address_ar }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Products Section --}}
            @if($products->count() > 0)
            <div class="products-section">
                <div class="info-section-title">
                    <h2>
                        <span class="hidden-ar">{{ __('booking.our_products', [], 'ar') }}</span>
                        <span class="hidden-en">{{ __('booking.our_products', [], 'en') }}</span>
                    </h2>
                    <p>
                        <span class="hidden-ar">{{ __('booking.choose_products', [], 'ar') }}</span>
                        <span class="hidden-en">{{ __('booking.choose_products', [], 'en') }}</span>
                    </p>
                </div>
                <div class="product-grid">
                    @foreach($products as $product)
                    <div class="product-card">
                        <div class="product-img-wrap">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name_ar }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-box text-4xl" style="color: #cbd5e1;"></i>
                                </div>
                            @endif
                            {{-- Availability badge --}}
                            <div class="product-badge {{ app()->getLocale() === 'ar' ? 'left-3' : 'right-3' }}" style="{{ app()->getLocale() === 'ar' ? 'left: 0.75rem;' : 'right: 0.75rem;' }} background: {{ $product->stock_quantity > 0 ? '#16a34a' : '#ef4444' }};">
                                @if($product->stock_quantity > 0)
                                    <span class="hidden-ar">{{ __('booking.available', [], 'ar') }}</span>
                                    <span class="hidden-en">{{ __('booking.available', [], 'en') }}</span>
                                @else
                                    <span class="hidden-ar">{{ __('booking.out_of_stock', [], 'ar') }}</span>
                                    <span class="hidden-en">{{ __('booking.out_of_stock', [], 'en') }}</span>
                                @endif
                            </div>
                            {{-- Price badge --}}
                            <div class="product-badge product-badge-price" style="{{ app()->getLocale() === 'ar' ? 'right: 0.75rem;' : 'left: 0.75rem;' }}">
                                {{ $product->price }} {{ $salon->currency }}
                            </div>
                        </div>
                        <div class="product-body">
                            <h3 class="product-name" data-ar="{{ $product->name_ar }}" data-en="{{ $product->name_en ?? $product->name_ar }}">{{ app()->getLocale() === 'ar' ? $product->name_ar : ($product->name_en ?? $product->name_ar) }}</h3>
                            @if(!empty($product->description_ar))
                            <p class="product-desc product-description" data-ar="{{ $product->description_ar }}" data-en="{{ $product->description_en ?? $product->description_ar }}">{{ app()->getLocale() === 'ar' ? $product->description_ar : ($product->description_en ?? $product->description_ar) }}</p>
                            @endif
                            <div class="product-footer">
                                <span class="stock-label">
                                    <span class="hidden-ar">{{ __('booking.stock_quantity', [], 'ar') }}</span>
                                    <span class="hidden-en">{{ __('booking.stock_quantity', [], 'en') }}</span>
                                </span>
                                @if($product->stock_quantity > 0)
                                <span class="stock-badge in-stock">
                                    <i class="fas fa-cube" style="font-size: 0.6rem;"></i>
                                    {{ $product->stock_quantity }}
                                </span>
                                @else
                                <span class="stock-badge out-stock">
                                    <i class="fas fa-times-circle" style="font-size: 0.6rem;"></i>
                                    <span class="hidden-ar">{{ __('booking.not_available', [], 'ar') }}</span>
                                    <span class="hidden-en">{{ __('booking.not_available', [], 'en') }}</span>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Footer --}}
        <footer class="page-footer">
            <p class="footer-text" data-ar="{{ $salon->name_ar }} © 2026 - {{ __('booking.all_rights_reserved', [], 'ar') }}" data-en="{{ $salon->name_en ?? $salon->name_ar }} © 2026 - {{ __('booking.all_rights_reserved', [], 'en') }}">
                {{ $salon->name_ar }} © 2026 - {{ __('booking.all_rights_reserved') }}
            </p>
            <a href="https://www.instagram.com/mohamed_izeldeen/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 mt-1 text-xs transition" style="color: var(--text-muted);">
                <i class="fab fa-instagram"></i>
                <span>{{ __('booking.developed_by') }}</span>
            </a>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
    let currentStep = 1;
    let selectedStaffId = '';
    let selectedServiceId = '';
    let selectedTime = '';
    let selectedDate = '';
    const salonId = {{ $salon->id }};
    const locale = '{{ app()->getLocale() }}';
    const currentLang = localStorage.getItem('language') || 'ar';

    @php
        $workDaysJs = is_string($salon->work_days) ? json_decode($salon->work_days, true) : $salon->work_days;
    @endphp
    const workDays = @json($workDaysJs);
    const openingTime = '{{ $salon->opening_time }}';
    const closingTime = '{{ $salon->closing_time }}';
    const salonCurrency = '{{ $salon->currency }}';
    const dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

    // Step Navigation
    function goToStep(step) {
        if (step > currentStep) {
            if (currentStep === 1 && !validateStep1()) return;
            if (currentStep === 2 && !validateStep2()) return;
            if (currentStep === 3 && !validateStep3()) return;
        }

        currentStep = step;

        // Update panels
        document.querySelectorAll('.step-panel').forEach(p => p.classList.remove('active'));
        document.querySelector(`[data-panel="${step}"]`).classList.add('active');

        // Update step pills
        document.querySelectorAll('.step-pill').forEach(pill => {
            const s = parseInt(pill.dataset.step);
            pill.classList.remove('active', 'done');
            const numEl = pill.querySelector('.step-num');
            if (s === step) {
                pill.classList.add('active');
                numEl.textContent = s;
            } else if (s < step) {
                pill.classList.add('done');
                numEl.innerHTML = '<i class="fas fa-check" style="font-size:0.65rem;"></i>';
            } else {
                numEl.textContent = s;
            }
        });

        // Update connectors
        document.querySelectorAll('.step-connector').forEach(con => {
            const afterStep = parseInt(con.dataset.after);
            con.classList.toggle('done', afterStep < step);
        });

        if (step === 4) buildSummary();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function validateStep1() {
        const name = document.getElementById('name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        if (!name || !phone) {
            shakeElement(document.querySelector('[data-panel="1"]'));
            return false;
        }
        return true;
    }

    function validateStep2() {
        if (!selectedServiceId) {
            shakeElement(document.getElementById('serviceGrid'));
            return false;
        }
        return true;
    }

    function validateStep3() {
        if (!selectedDate || !selectedTime) {
            shakeElement(document.querySelector('[data-panel="3"]'));
            return false;
        }
        return true;
    }

    function shakeElement(el) {
        el.style.animation = 'none';
        el.offsetHeight;
        el.style.animation = 'shake 0.5s ease';
        setTimeout(() => el.style.animation = '', 500);
    }

    // Staff Selection
    function selectStaff(card, id) {
        // Prevent selecting busy staff
        if (card.classList.contains('staff-busy')) return;
        document.querySelectorAll('.staff-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        selectedStaffId = id;
        document.getElementById('staffInput').value = id;
        filterServicesByStaff();
    }

    function filterServicesByStaff() {
        document.querySelectorAll('.service-card').forEach(card => {
            if (!selectedStaffId) { card.style.display = ''; return; }
            const staffIds = JSON.parse(card.dataset.staffIds || '[]');
            if (staffIds.includes(parseInt(selectedStaffId))) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
                if (card.classList.contains('selected')) {
                    card.classList.remove('selected');
                    selectedServiceId = '';
                    document.getElementById('serviceInput').value = '';
                }
            }
        });
    }

    // Service Selection
    function selectService(card, id) {
        document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        selectedServiceId = id;
        document.getElementById('serviceInput').value = id;
    }

    // Time Slot
    function selectTimeSlot(el, time) {
        if (el.classList.contains('disabled')) return;
        document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
        el.classList.add('selected');
        selectedTime = time;
        document.getElementById('timeInput').value = time;

        // Check which staff are available at this time
        if (selectedServiceId && selectedDate) {
            updateStaffAvailability();
        }
    }

    // Date & working day check
    function isWorkingDay(date) {
        return workDays.includes(dayNames[date.getDay()]);
    }

    const dateInput = document.getElementById('date');
    flatpickr(dateInput, {
        minDate: new Date(),
        disable: [function(date) { return !isWorkingDay(date); }],
        dateFormat: 'Y-m-d',
        onChange: function(selectedDates) {
            if (selectedDates.length > 0) {
                selectedDate = dateInput.value;
                generateTimeSlots();
            }
        }
    });

    function generateTimeSlots() {
        const grid = document.getElementById('timeSlotsGrid');
        const openParts = openingTime.split(':');
        const closeParts = closingTime.split(':');
        let openH = parseInt(openParts[0]), openM = parseInt(openParts[1]);
        let closeH = parseInt(closeParts[0]), closeM = parseInt(closeParts[1]);

        let html = '';
        let h = openH, m = openM;

        while (h < closeH || (h === closeH && m < closeM)) {
            const timeStr = String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0');
            html += `<div class="time-slot" onclick="selectTimeSlot(this, '${timeStr}')">${timeStr}</div>`;
            m += 30;
            if (m >= 60) { m = 0; h++; }
        }

        grid.innerHTML = html || '<p class="col-span-full text-center py-4" style="color: var(--text-muted);">No available slots</p>';

        if (selectedStaffId && selectedServiceId && selectedDate) {
            checkTimeSlotsAvailability();
        }
    }

    function checkTimeSlotsAvailability() {
        document.querySelectorAll('.time-slot').forEach(slot => {
            const time = slot.textContent.trim();
            fetch(`/api/staff/${selectedStaffId}/availability?date=${selectedDate}&time=${time}&service_id=${selectedServiceId}`)
                .then(r => r.json())
                .then(data => {
                    if (!data.available) {
                        slot.classList.add('disabled');
                        if (slot.classList.contains('selected')) {
                            slot.classList.remove('selected');
                            selectedTime = '';
                            document.getElementById('timeInput').value = '';
                        }
                    }
                })
                .catch(() => {});
        });
    }

    function updateStaffAvailability() {
        if (!selectedDate || !selectedTime || !selectedServiceId) return;

        fetch(`/api/salon/${salonId}/available-staff?date=${selectedDate}&time=${selectedTime}&service_id=${selectedServiceId}`)
            .then(r => r.json())
            .then(data => {
                const staffMap = {};
                (data.staff || []).forEach(s => { staffMap[String(s.id)] = s.available; });

                document.querySelectorAll('.staff-card[data-staff-id]').forEach(card => {
                    const sid = card.dataset.staffId;
                    const dot = card.querySelector('.staff-avail-dot');

                    if (!sid) {
                        // "Any available" card — always available
                        if (dot) { dot.className = 'staff-avail-dot show free'; }
                        card.classList.remove('staff-busy');
                        return;
                    }

                    if (staffMap[sid] === true) {
                        card.classList.remove('staff-busy');
                        if (dot) { dot.className = 'staff-avail-dot show free'; }
                    } else if (staffMap[sid] === false) {
                        card.classList.add('staff-busy');
                        if (dot) { dot.className = 'staff-avail-dot show busy'; }
                        // If this busy staff was selected, reset to "Any available"
                        if (card.classList.contains('selected')) {
                            card.classList.remove('selected');
                            const anyCard = document.querySelector('.staff-card[data-staff-id=""]');
                            if (anyCard) { anyCard.classList.add('selected'); }
                            selectedStaffId = '';
                            document.getElementById('staffInput').value = '';
                        }
                    } else {
                        // Staff not in list (doesn't serve this service)
                        card.classList.add('staff-busy');
                        if (dot) { dot.className = 'staff-avail-dot'; }
                    }
                });
            })
            .catch(() => {});
    }

    // Build Summary
    function buildSummary() {
        const lang = localStorage.getItem('language') || 'ar';
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const email = document.getElementById('email').value;

        const serviceCard = document.querySelector(`.service-card[data-service-id="${selectedServiceId}"]`);
        const serviceName = serviceCard ? serviceCard.querySelector('.service-name').getAttribute(`data-${lang}`) : '';
        const servicePrice = serviceCard ? serviceCard.dataset.price : '';

        const staffCard = document.querySelector('.staff-card.selected');
        const staffName = staffCard ? staffCard.querySelector('.staff-name').getAttribute(`data-${lang}`) : '';

        const labels = {
            client: lang === 'ar' ? 'العميل' : 'Client',
            phone: lang === 'ar' ? 'الهاتف' : 'Phone',
            email: lang === 'ar' ? 'البريد' : 'Email',
            service: lang === 'ar' ? 'الخدمة' : 'Service',
            staff: lang === 'ar' ? 'الموظف' : 'Staff',
            date: lang === 'ar' ? 'التاريخ' : 'Date',
            time: lang === 'ar' ? 'الوقت' : 'Time',
            total: lang === 'ar' ? 'الإجمالي' : 'Total'
        };

        let html = `
            <div class="summary-row"><span class="summary-label"><i class="fas fa-user"></i>${labels.client}</span><span class="summary-value">${name}</span></div>
            <div class="summary-row"><span class="summary-label"><i class="fas fa-phone"></i>${labels.phone}</span><span class="summary-value ltr">${phone}</span></div>
            ${email ? `<div class="summary-row"><span class="summary-label"><i class="fas fa-envelope"></i>${labels.email}</span><span class="summary-value ltr">${email}</span></div>` : ''}
            <div class="summary-row"><span class="summary-label"><i class="fas fa-spa"></i>${labels.service}</span><span class="summary-value">${serviceName}</span></div>
            <div class="summary-row"><span class="summary-label"><i class="fas fa-user-tie"></i>${labels.staff}</span><span class="summary-value">${staffName}</span></div>
            <div class="summary-row"><span class="summary-label"><i class="fas fa-calendar"></i>${labels.date}</span><span class="summary-value ltr">${selectedDate}</span></div>
            <div class="summary-row"><span class="summary-label"><i class="fas fa-clock"></i>${labels.time}</span><span class="summary-value ltr">${selectedTime}</span></div>
            <div class="summary-row" style="border-top: 2px solid var(--accent-light); padding-top: 1rem; margin-top: 0.5rem; border-bottom: none;">
                <span style="font-weight: 800; color: var(--accent); font-size: 1rem;">${labels.total}</span>
                <span style="font-weight: 900; color: var(--accent); font-size: 1.25rem;">${servicePrice} ${salonCurrency}</span>
            </div>`;

        document.getElementById('summaryCard').innerHTML = html;
    }

    // Language switching
    function switchLanguage(lang) {
        const html = document.documentElement;
        const btns = document.querySelectorAll('.lang-btn');

        if (lang === 'ar') {
            html.classList.remove('en'); html.lang = 'ar'; html.dir = 'rtl';
            btns[0].classList.add('active'); btns[1].classList.remove('active');
        } else {
            html.classList.add('en'); html.lang = 'en'; html.dir = 'ltr';
            btns[1].classList.add('active'); btns[0].classList.remove('active');
        }
        localStorage.setItem('language', lang);
        updateTexts(lang);
    }

    function updateTexts(lang) {
        document.querySelectorAll('.staff-name').forEach(el => {
            el.textContent = el.getAttribute(`data-${lang}`) || el.textContent;
        });
        document.querySelectorAll('.service-name').forEach(el => {
            el.textContent = el.getAttribute(`data-${lang}`) || el.textContent;
        });
        document.querySelectorAll('.product-name').forEach(el => {
            el.textContent = el.getAttribute(`data-${lang}`) || el.textContent;
        });
        document.querySelectorAll('.product-description').forEach(el => {
            el.textContent = el.getAttribute(`data-${lang}`) || el.textContent;
        });
        const footer = document.querySelector('.footer-text');
        if (footer) footer.textContent = footer.getAttribute(`data-${lang}`) || footer.textContent;
        const success = document.querySelector('.success-title');
        if (success) success.textContent = success.getAttribute(`data-${lang}`) || success.textContent;
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        if (nameInput) nameInput.placeholder = nameInput.getAttribute(`data-${lang}-placeholder`) || nameInput.placeholder;
        if (emailInput) emailInput.placeholder = emailInput.getAttribute(`data-${lang}-placeholder`) || emailInput.placeholder;
    }

    // Shake animation
    const shakeStyle = document.createElement('style');
    shakeStyle.textContent = '@keyframes shake { 0%,100% { transform: translateX(0); } 20%,60% { transform: translateX(-8px); } 40%,80% { transform: translateX(8px); } }';
    document.head.appendChild(shakeStyle);

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        switchLanguage(localStorage.getItem('language') || 'ar');
    });
    </script>
</body>
</html>
