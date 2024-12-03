<?php

namespace App\Http\Controllers;

use App\Models\Sendbill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SendbillController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:sendbill-list|sendbill-create|sendbill-edit|sendbill-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:sendbill-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sendbill-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sendbill-delete', ['only' => ['destroy']]);
        $this->middleware('permission:change_status_sendbill', ['only' => ['changeStatus']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // بررسی سطح دسترسی برای مشاهده همه قبض‌ها
        $sendbills = Auth::user()->can('access_all_bill_sendbill')
            ? Sendbill::latest()->paginate(10) // نمایش همه قبض‌ها
            : Sendbill::where('user_id', Auth::id())->latest()->paginate(10); // نمایش قبض‌های مرتبط با کاربر جاری


        return view('admin.sendbill.index', compact('sendbills'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sendbill.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'name' => 'required|string|max:255',
            // 'phone' => 'required|string|max:50',
            // 'economic_unit' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpeg,png,pdf,docx|max:2048',
        ], [
            // 'name.required' => 'نام و نام خانوادگی الزامی است.',
            // 'phone.required' => 'شماره تماس الزامی است.',
            // 'economic_unit.required' => 'نام واحد اقتصادی الزامی است.',
            'file.required' => 'فایل الزامی است.',
            'file.mimes' => 'فایل باید از نوع jpeg, png, pdf یا docx باشد.',
        ]);

        $filePath = $request->file('file')->storeAs(
            'sendbills/' . Auth::user()->email,
            $request->file('file')->getClientOriginalName(),
            'public'
        );

        $user = Auth::user();

        Sendbill::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'job' => $user->additionalinformation->job,
            'phone' => $user->mobile,
            'economic_unit' => $user->additionalinformation->economic_unit,
            'ceo_name' => $user->additionalinformation->ceo_name,
            'contractual_power' => $request->contractual_power,
            'file' => $filePath,
        ]);

        return redirect()->route('sendbills.index')->with('success', 'قبض با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sendbill = Sendbill::findOrFail($id);

        if (!Auth::user()->hasRole('Admin')) {
            if ($sendbill->user_id !== Auth::id()) {
                abort(403, 'شما اجازه دسترسی به این قبض را ندارید.');
            }
        }

        return view('admin.sendbill.show', compact('sendbill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sendbill = Sendbill::findOrFail($id);

        if (!Auth::user()->hasRole('Admin')) {
            if ($sendbill->user_id !== Auth::id()) {
                abort(403, 'شما اجازه ویرایش این قبض را ندارید.');
            }
        }

        return view('admin.sendbill.edit', compact('sendbill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sendbill = Sendbill::findOrFail($id);

        if (!Auth::user()->hasRole('Admin')) {
            if ($sendbill->user_id !== Auth::id()) {
                abort(403, 'شما اجازه ویرایش این قبض را ندارید.');
            }
        }

        // اعتبارسنجی داده‌ها
        $request->validate([
            // 'name' => 'required|string|max:255',
            // 'phone' => 'required|string|max:50',
            // 'economic_unit' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpeg,png,pdf,docx|max:2048',
        ], [
            // 'name.required' => 'نام و نام خانوادگی الزامی است.',
            // 'phone.required' => 'شماره تماس الزامی است.',
            // 'economic_unit.required' => 'نام واحد اقتصادی الزامی است.',
            'file.mimes' => 'فایل باید از نوع jpeg, png, pdf یا docx باشد.',
        ]);

        // اگر فایل جدیدی آپلود شده باشد
        if ($request->hasFile('file')) {
            // ساخت مسیر جدید برای فایل
            $filePath = $request->file('file')->storeAs(
                'sendbills/' . Auth::user()->email, // فولدر با ایمیل کاربر
                $request->file('file')->getClientOriginalName(), // نام فایل اصلی
                'public' // دیسک ذخیره‌سازی
            );

            // حذف فایل قبلی در صورت وجود
            if (!empty($sendbill->file) && Storage::disk('public')->exists($sendbill->file)) {
                Storage::disk('public')->delete($sendbill->file);
            }

            // به‌روزرسانی مسیر فایل جدید
            $sendbill->file = $filePath;
        }

        $user = Auth::user();

        // به‌روزرسانی داده‌ها
        $sendbill->update([
            'name' => $user->name,
            'job' => $user->additionalinformation->job,
            'phone' => $user->mobile,
            'economic_unit' => $user->additionalinformation->economic_unit,
            'ceo_name' => $user->additionalinformation->ceo_name,
            'contractual_power' => $request->contractual_power,
            'status' => $request->status ?? $sendbill->status,
        ]);

        return redirect()->route('sendbills.index')->with('success', 'قبض با موفقیت ویرایش شد.');
    }


    /**
     * Change the status of the specified resource.
     */
    public function changeStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirm,reject',
        ], [
            'status.required' => 'وضعیت الزامی است.',
            'status.in' => 'وضعیت انتخاب‌شده معتبر نیست.',
        ]);

        $sendbill = Sendbill::findOrFail($id);

        // بررسی سطح دسترسی
        if (!Auth::user()->can('change_status_sendbill')) {
            abort(403, 'شما اجازه تغییر وضعیت این قبض را ندارید.');
        }

        $sendbill->update([
            'status' => $request->status,
        ]);

        return redirect()->route('sendbills.index')->with('success', 'وضعیت قبض با موفقیت تغییر کرد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sendbill = Sendbill::findOrFail($id);

        if (!Auth::user()->hasRole('Admin')) {
            if ($sendbill->user_id !== Auth::id()) {
                abort(403, 'شما اجازه حذف این قبض را ندارید.');
            }
        }

        $sendbill->delete();

        return redirect()->route('sendbills.index')->with('success', 'قبض با موفقیت حذف شد.');
    }
}
