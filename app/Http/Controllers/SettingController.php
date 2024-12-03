<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:setting-list', ['only' => ['edit']]);
        $this->middleware('permission:setting-edit', ['only' => ['update']]);
    }

    public function edit()
    {
        $settings = get_settings();
        return view('admin.setting.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        update_setting('percent_include', $request->percent_include);
        update_setting('percent_not_include', $request->percent_not_include);
        update_setting('middle_load_electricity_supply_rate', $request->middle_load_electricity_supply_rate);
        update_setting('peak_load_electricity_supply_rate', $request->peak_load_electricity_supply_rate);
        update_setting('low_load_electricity_supply_rate', $request->low_load_electricity_supply_rate);
        update_setting('middle_load_allocation_coefficient', $request->middle_load_allocation_coefficient);
        update_setting('peak_load_allocation_coefficient', $request->peak_load_allocation_coefficient);
        update_setting('low_load_allocation_coefficient', $request->low_load_allocation_coefficient);
        return redirect()->back()->with('success', 'تنظیمات با موفقیت ذخیره شد.');

    }
}
