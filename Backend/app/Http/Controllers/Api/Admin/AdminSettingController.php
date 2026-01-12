<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'required',
        ]);

        foreach ($request->settings as $settingData) {
            Setting::where('key', $settingData['key'])
                ->update(['value' => $settingData['value']]);
        }

        return response()->json(['message' => 'Settings updated successfully']);
    }
}
