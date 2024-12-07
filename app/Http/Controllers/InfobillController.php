<?php

namespace App\Http\Controllers;

use App\Models\Infobill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InfobillController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:infobill-list|infobill-create|infobill-edit|infobill-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:infobill-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:infobill-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:infobill-delete', ['only' => ['destroy']]);
        $this->middleware('permission:change_status_infobill', ['only' => ['changeStatus']]);
    }

    public function index(Request $request)
    {
        $infobills = Auth::user()->can('access_all_bill_infobill')
            ? Infobill::latest()->paginate(10)
            : Infobill::where('user_id', Auth::id())->latest()->paginate(10);

        return view('admin.infobill.index', compact('infobills'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        $settings = get_settings();
        return view('admin.infobill.create', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contractual_power' => 'nullable|max:50',
            'made16_status' => 'required|in:yes,no',
            'Two_way_electricity_rate' => 'nullable|numeric',
            'middle_load_meter_consumption' => 'nullable|numeric',
            'middle_load_allocation_coefficient' => 'nullable|numeric',
            'middle_load_electricity_supply_rate' => 'nullable|numeric',
            'peak_load_meter_consumption' => 'nullable|numeric',
            'peak_load_allocation_coefficient' => 'nullable|numeric',
            'peak_load_electricity_supply_rate' => 'nullable|numeric',
            'low_load_meter_consumption' => 'nullable|numeric',
            'low_load_allocation_coefficient' => 'nullable|numeric',
            'low_load_electricity_supply_rate' => 'nullable|numeric',
            'status' => 'nullable|in:pending,confirm,reject',
        ]);


        $total = $request->middle_load_allocation_coefficient + $request->peak_load_allocation_coefficient + $request->low_load_allocation_coefficient;
        if($total > 24){
            return redirect()->back()->with('error', 'مجموع مقادیر تخصیص می بایست ۲۴ باشد.');
        }

        $user = Auth::user();

        $validated['user_id'] = $user->id;
        $validated['name'] = $user->name;
        $validated['job'] = $user->additionalinformation->job;
        $validated['phone'] = $user->mobile;
        $validated['economic_unit'] = $user->additionalinformation->economic_unit;
        $validated['ceo_name'] = $user->additionalinformation->ceo_name;

        $record = Infobill::create($validated);

        return redirect()->route('infobills.bill', $record->id)->with('success', 'قبض با موفقیت ایجاد شد.');
    }

    public function edit(string $id)
    {
        $infobill = Infobill::findOrFail($id);

        if (!Auth::user()->hasRole('Admin')) {
            if ($infobill->user_id !== Auth::id()) {
                abort(403, 'شما اجازه ویرایش این قبض را ندارید.');
            }
        }

        return view('admin.infobill.edit', compact('infobill'));
    }


    public function update(Request $request, string $id)
    {
        $infobill = Infobill::findOrFail($id);

        if (!Auth::user()->hasRole('Admin')) {
            if ($infobill->user_id !== Auth::id()) {
                abort(403, 'شما اجازه ویرایش این قبض را ندارید.');
            }
        }

        $validated = $request->validate([
            'contractual_power' => 'nullable|max:50',
            'made16_status' => 'required|in:yes,no',
            'Two_way_electricity_rate' => 'nullable|numeric',
            'middle_load_meter_consumption' => 'nullable|numeric',
            'middle_load_allocation_coefficient' => 'nullable|numeric',
            'middle_load_electricity_supply_rate' => 'nullable|numeric',
            'peak_load_meter_consumption' => 'nullable|numeric',
            'peak_load_allocation_coefficient' => 'nullable|numeric',
            'peak_load_electricity_supply_rate' => 'nullable|numeric',
            'low_load_meter_consumption' => 'nullable|numeric',
            'low_load_allocation_coefficient' => 'nullable|numeric',
            'low_load_electricity_supply_rate' => 'nullable|numeric',
            'status' => 'nullable|in:pending,confirm,reject',
        ]);

        $total = $request->middle_load_allocation_coefficient + $request->peak_load_allocation_coefficient + $request->low_load_allocation_coefficient;
        if($total > 24){
            return redirect()->back()->with('error', 'مجموع مقادیر تخصیص می بایست ۲۴ باشد.');
        }

        $user = Auth::user();

        $validated['name'] = $user->name;
        $validated['job'] = $user->additionalinformation->job;
        $validated['phone'] = $user->mobile;
        $validated['economic_unit'] = $user->additionalinformation->economic_unit;
        $validated['ceo_name'] = $user->additionalinformation->ceo_name;

        $infobill->update($validated);

        return redirect()->route('infobills.index')->with('success', 'قبض با موفقیت ویرایش شد.');
    }

    public function destroy(string $id)
    {
        $infobill = Infobill::findOrFail($id);

        if (!Auth::user()->hasRole('Admin')) {
            if ($infobill->user_id !== Auth::id()) {
                abort(403, 'شما اجازه حذف این قبض را ندارید.');
            }
        }

        $infobill->delete();

        return redirect()->route('infobills.index')->with('success', 'قبض با موفقیت حذف شد.');
    }

    public function bill(string $id)
    {
        $included = get_setting('percent_include');
        $not_included = get_setting('percent_not_include');

        $record = Infobill::findOrFail($id);

        if (!Auth::user()->hasRole('Admin')) {
            if ($record->user_id !== Auth::id()) {
                abort(403, 'شما اجازه مشاهده این قبض را ندارید.');
            }
        }

        return view('admin.infobill.bill', compact(['record', 'included', 'not_included']));
    }
}
