<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // user preference falls back to session if no authenticated user
        $darkMode = $user ? (bool) $user->dark_mode : session('dark_mode', false);
        $notificationsEnabled = $user ? (bool) $user->notifications_enabled : session('notifications_enabled', true);

        // Notification toggles stored in settings (key-value)
        $emailNotificationsEnabled = Setting::get('notify.email_enabled', true);
        $smsNotificationsEnabled = Setting::get('notify.sms_enabled', false);
        $invoiceRemindersEnabled = Setting::get('notify.invoice_reminders', true);
        $lowStockEnabled = Setting::get('notify.low_stock', true);
        $weeklySummaryEnabled = Setting::get('notify.weekly_summary', false);

        return view('settings.index', compact(
            'darkMode', 'notificationsEnabled',
            'emailNotificationsEnabled', 'smsNotificationsEnabled',
            'invoiceRemindersEnabled', 'lowStockEnabled', 'weeklySummaryEnabled'
        ));
    }

    public function editProfile()
    {
        return view('settings.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('settings.profile')->with('success', 'Profile updated successfully.');
    }

    public function editPassword()
    {
        return view('settings.password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('settings.password')->with('success', 'Password updated successfully.');
    }

    public function toggleTheme()
    {
        $current = session('dark_mode', false);
        $new = !$current;

        // persist to user if authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $user->dark_mode = $new;
            $user->save();
        }

        session(['dark_mode' => $new]);

        return response()->json([
            'success' => true,
            'dark_mode' => $new,
        ]);
    }

    public function toggleNotifications()
    {
        $current = session('notifications_enabled', true);
        $new = !$current;

        if (Auth::check()) {
            $user = Auth::user();
            $user->notifications_enabled = $new;
            $user->save();
        }

        session(['notifications_enabled' => $new]);

        return response()->json([
            'success' => true,
            'notifications_enabled' => $new,
        ]);
    }

    public function updateApp(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string',
            'theme_color' => 'nullable|string',
            'currency' => 'required|string',
            'timezone' => 'required|string',
            'date_format' => 'required|string',
            'logo' => 'nullable|file|image|max:2048',
            'favicon' => 'nullable|file|mimes:ico,png|max:512',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('branding', 'public');
            \App\Models\Setting::set('app.logo_path', $validated['logo']);
        }

        if ($request->hasFile('favicon')) {
            $validated['favicon'] = $request->file('favicon')->store('branding', 'public');
            \App\Models\Setting::set('app.favicon_path', $validated['favicon']);
        }

        \App\Models\Setting::set('app.name', $validated['app_name']);
        \App\Models\Setting::set('app.theme_color', $validated['theme_color']);
        \App\Models\Setting::set('app.currency', $validated['currency']);
        \App\Models\Setting::set('app.timezone', $validated['timezone']);
        \App\Models\Setting::set('app.date_format', $validated['date_format']);

        return back()->with('success', 'Application settings updated successfully.');
    }

    public function updateCompany(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'website' => 'nullable|url',
            'address' => 'nullable|string',
            'tax_id' => 'nullable|string',
            'invoice_footer' => 'nullable|string',
        ]);

        \App\Models\Setting::set('company.name', $validated['company_name']);
        \App\Models\Setting::set('company.email', $validated['email']);
        \App\Models\Setting::set('company.phone', $validated['phone']);
        \App\Models\Setting::set('company.website', $validated['website']);
        \App\Models\Setting::set('company.address', $validated['address']);
        \App\Models\Setting::set('company.tax_id', $validated['tax_id']);
        \App\Models\Setting::set('company.invoice_footer', $validated['invoice_footer']);

        return back()->with('success', 'Company information updated successfully.');
    }

    public function updateIntegrations(Request $request)
    {
        $validated = $request->validate([
            'integrations.amazon.api_key' => 'nullable|string',
            'integrations.amazon.seller_id' => 'nullable|string',
            'integrations.ebay.app_id' => 'nullable|string',
            'integrations.ebay.dev_id' => 'nullable|string',
            'integrations.ebay.cert_id' => 'nullable|string',
            'integrations.smtp.host' => 'nullable|string',
            'integrations.smtp.port' => 'nullable|string',
            'integrations.smtp.username' => 'nullable|string',
            'integrations.smtp.password' => 'nullable|string',
            'integrations.smtp.encryption' => 'nullable|string',
            'integrations.smtp.from_email' => 'nullable|email',
        ]);

        foreach ($validated as $key => $value) {
            \App\Models\Setting::set($key, $value);
        }

        return back()->with('success', 'Integrations updated successfully.');
    }
}