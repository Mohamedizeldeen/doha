<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Salon;
use App\Models\PasswordResetOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('salon.index');
        }
        
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if account is blocked by super admin
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => __('admin.account_blocked_message'),
                ]);
            }

            // Check if user is super admin
            if ($user->role === 'super_admin') {
                return redirect()->route('superAdmin.dashboard');
            }

            // Check if user is sales person
            if ($user->role === 'sales') {
                return redirect()->route('sales.dashboard');
            }

            // Regular admin/salon owner
            $salon = $user->salons()->first();

            if (!$salon) {
                return redirect()->route('salon.create');
            }

            $now = now();

            // Check if subscription has ended - auto deactivate account
            if ($salon->subscription_end_date && $now->greaterThan($salon->subscription_end_date)) {
                // Auto-deactivate the account
                $user->update(['is_active' => false]);

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')->withErrors([
                    'email' => __('admin.subscription_expired_message'),
                ]);
            }

            return redirect()->route('admin.dashboard', [
                'salon_id' => $salon->id
            ]);
        }

        return back()->withErrors([
            'email' => __('messages.login_failed'),
        ])->onlyInput('email');
    }


    /**
     * Show registration form
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('salon.index');
        }
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('salon.create');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }

    public function getNotSuperAdminUsers()
    {
        $users = User::where('role', '!=', 'super_admin')->get();
        return view('superAdmin.users.index', compact('users'));
    }

    /**
     * Show forgot password form (phone-based)
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send OTP via WhatsApp
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $phone = $request->phone;

        // Find user by phone
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return back()->withErrors(['phone' => __('auth.phone_not_found')]);
        }

        // Invalidate any previous OTPs for this phone
        PasswordResetOtp::where('phone', $phone)->update(['used' => true]);

        // Generate 6-digit OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP (valid for 10 minutes)
        PasswordResetOtp::create([
            'phone' => $phone,
            'otp_code' => $otpCode,
            'expires_at' => now()->addMinutes(10),
            'used' => false,
        ]);

        // Store phone in session for the verify page
        session(['otp_phone' => $phone]);

        // Build WhatsApp message with OTP
        $message = __('auth.whatsapp_otp_message', ['code' => $otpCode]);
        $whatsappNumber = preg_replace('/[^0-9]/', '', $phone);
        $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode($message);

        // Store WhatsApp URL in session so admin can send it
        session(['otp_whatsapp_url' => $whatsappUrl]);
        session(['otp_code_display' => $otpCode]);

        return redirect()->route('password.verify.form')->with('otp_sent', true);
    }

    /**
     * Show OTP verification form
     */
    public function showVerifyOtp()
    {
        $phone = session('otp_phone');
        if (!$phone) {
            return redirect()->route('password.request');
        }

        $whatsappUrl = session('otp_whatsapp_url');
        $otpCode = session('otp_code_display');

        // Build WhatsApp link for user to contact admin
        $adminWhatsappUrl = 'https://wa.me/96890804952?text=' . urlencode(__('auth.whatsapp_request_code', ['phone' => $phone]));

        return view('auth.verify-otp', compact('phone', 'adminWhatsappUrl', 'whatsappUrl', 'otpCode'));
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|size:6',
        ]);

        $phone = session('otp_phone');
        if (!$phone) {
            return redirect()->route('password.request');
        }

        // Find valid OTP
        $otp = PasswordResetOtp::where('phone', $phone)
            ->where('otp_code', $request->otp_code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return back()->withErrors(['otp_code' => __('auth.invalid_otp')]);
        }

        // Mark OTP as used
        $otp->update(['used' => true]);

        // Store verified phone in session for password reset
        session(['otp_verified_phone' => $phone]);
        session()->forget(['otp_phone', 'otp_whatsapp_url', 'otp_code_display']);

        return redirect()->route('password.reset.otp');
    }

    /**
     * Show reset password form (after OTP verification)
     */
    public function showResetWithOtp()
    {
        $phone = session('otp_verified_phone');
        if (!$phone) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password-otp', compact('phone'));
    }

    /**
     * Reset password after OTP verification
     */
    public function resetWithOtp(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $phone = session('otp_verified_phone');
        if (!$phone) {
            return redirect()->route('password.request');
        }

        $user = User::where('phone', $phone)->first();
        if (!$user) {
            return redirect()->route('password.request')->withErrors(['phone' => __('auth.phone_not_found')]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        session()->forget('otp_verified_phone');

        return redirect()->route('login')->with('status', __('auth.password_reset_success'));
    }

    /**
     * Change password (for authenticated users)
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => __('auth.wrong_current_password')]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('password_success', __('auth.password_changed'));
    }

    public function destroyUser(User $user)
    {
        if ($user->role === 'super_admin') {
            return redirect()->route('superAdmin.users.index')->withErrors(__('messages.cannot_delete_superadmin'));
        }

        $user->delete();
        return redirect()->route('superAdmin.users.index')->with('success', __('messages.user_deleted'));
    }
}

