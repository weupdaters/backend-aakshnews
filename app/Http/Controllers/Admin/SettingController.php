<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the site and social media settings page.
     */
    public function index(Request $request)
    {
        $lang = session('lang', 'en');
        $settings = Setting::getAllSettings();

        // Localized dictionary for settings page
        $t = [
            'settings'            => $lang === 'hi' ? 'सेटिंग्स' : ($lang === 'pb' ? 'ਸੈਟਿੰਗਾਂ' : 'Site Settings'),
            'branding_settings'   => $lang === 'hi' ? 'ब्रांडिंग और लोगो' : ($lang === 'pb' ? 'ਬ੍ਰਾਂਡਿੰਗ ਅਤੇ ਲੋਗੋ' : 'Brand Identity & Logo'),
            'seo_settings'        => $lang === 'hi' ? 'एसईओ और मेटा सेटिंग्स' : ($lang === 'pb' ? 'ਐਸ.ਈ.ਓ. ਅਤੇ ਮੈਟਾ ਸੈਟਿੰਗਾਂ' : 'SEO & Meta Settings'),
            'social_media'        => $lang === 'hi' ? 'सोशल मीडिया लिंक्स' : ($lang === 'pb' ? 'ਸੋਸ਼ਲ ਮੀਡੀਆ ਲਿੰਕ' : 'Social Media Links'),
            'social_media_desc'   => $lang === 'hi' ? 'जो लिंक आप खाली छोड़ेंगे वह वेबसाइट पर नहीं दिखेगा।' : ($lang === 'pb' ? 'ਜਿਹੜਾ ਲਿੰਕ ਤੁਸੀਂ ਖਾਲੀ ਛੱਡੋਗੇ ਉਹ ਵੈੱਬਸਾਈਟ ’ਤੇ ਨਹੀਂ ਦਿਖੇਗਾ।' : 'Empty links will be automatically hidden from the website.'),
            'general_settings'    => $lang === 'hi' ? 'सामान्य सेटिंग्स' : ($lang === 'pb' ? 'ਆਮ ਸੈਟਿੰਗਾਂ' : 'General & Contact Settings'),
            'save_settings'       => $lang === 'hi' ? 'सेटिंग्स सेव करें' : ($lang === 'pb' ? 'ਸੈਟਿੰਗਾਂ ਸੰਭਾਲੋ' : 'Save Settings'),
            'settings_updated'    => $lang === 'hi' ? 'सेटिंग्स सफलतापूर्वक अपडेट हो गईं!' : ($lang === 'pb' ? 'ਸੈਟਿੰਗਾਂ ਸਫਲਤਾਪੂਰਵਕ ਅੱਪਡੇਟ ਹੋ ਗਈਆਂ!' : 'Settings updated successfully!'),
        ];

        return view('admin.settings.index', compact('settings', 'lang', 't'));
    }

    /**
     * Update settings in database.
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method', 'site_logo', 'site_favicon']);

        // Handle Site Logo Upload
        if ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            $fileName = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $destPath = public_path('uploads/settings');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0777, true);
            }
            $file->move($destPath, $fileName);
            Setting::set('site_logo', 'uploads/settings/' . $fileName, 'branding');
        }

        // Handle Site Favicon / Site Icon Upload
        if ($request->hasFile('site_favicon')) {
            $file = $request->file('site_favicon');
            $fileName = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $destPath = public_path('uploads/settings');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0777, true);
            }
            $file->move($destPath, $fileName);
            Setting::set('site_favicon', 'uploads/settings/' . $fileName, 'branding');
        }

        // Process all remaining text & URL settings
        foreach ($data as $key => $value) {
            $group = 'general';
            if (str_contains($key, '_url')) {
                $group = 'social';
            } elseif (str_starts_with($key, 'meta_')) {
                $group = 'seo';
            } elseif (str_starts_with($key, 'site_')) {
                $group = 'branding';
            }
            Setting::set($key, trim($value ?? ''), $group);
        }

        return redirect()->back()->with('success', 'Settings updated successfully! Changes are live on the website.');
    }

    /**
     * Display the website specific configuration page.
     */
    public function websiteSettings(Request $request)
    {
        $lang = session('lang', 'en');
        $settings = Setting::getAllSettings();

        return view('admin.settings.website', compact('settings', 'lang'));
    }

    /**
     * Update website specific settings.
     */
    public function updateWebsiteSettings(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            Setting::set($key, is_string($value) ? trim($value) : $value, 'website');
        }

        return redirect()->back()->with('success', 'Website settings updated successfully! Changes are live immediately.');
    }
}
