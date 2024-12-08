<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{

    public function login()
    {
        return view('otp.login');
    }

    public function verifycode_form()
    {
        return view('otp.verifycode');
    }

    public function sendVerificationCode(Request $request)
    {

        $code = rand(100000, 999999);

        $request->validate(
            [
                'mobile' => 'required|regex:/^[0][9][0-9]{9,9}$/',
            ],
            [
                'mobile.regex' => 'فرمت شماره موبایل صحیح نمی باشد'
            ]
        );

        $existingUser = verification::where(['mobile' => $request->mobile])->first();
        if ($existingUser) {
            DB::table('verifications')
                ->where('mobile', $request->mobile)
                ->update([
                    'code' => $code,
                    'expires_at' => now()->addMinutes(6),
                ]);
        } else {
            DB::table('verifications')->insert([
                'mobile' => $request->mobile,
                'code' => $code,
                'expires_at' => now()->addMinutes(6),
            ]);
        }

        setcookie('mobile', $request->mobile, time() + 300);  /* expire in 1 hour */


        send_sms($request->mobile, $code);

        return response()->json(['status' => 'ok', 'url' => route('verify.form')], 200);
    }

    public function resendCode(Request $request)
    {
        if (isset($_COOKIE["mobile"])) {

            $code = rand(100000, 999999);

            $existingUser = verification::where(['mobile' => $_COOKIE["mobile"]])->first();
            if ($existingUser) {
                DB::table('verifications')
                    ->where('mobile', $_COOKIE["mobile"])
                    ->update([
                        'code' => $code,
                        'expires_at' => now()->addMinutes(6),
                    ]);
            } else {
                DB::table('verifications')->insert([
                    'mobile' => $_COOKIE["mobile"],
                    'code' => $code,
                    'expires_at' => now()->addMinutes(6),
                ]);
            }

            setcookie('mobile', $_COOKIE["mobile"], time() + 300);  /* expire in 1 hour */


            send_sms($_COOKIE["mobile"], $code);

            return response()->json(['status' => 'ok', 'url' => route('verify.form')], 200);
        } else {
            return response()->json(['message' => 'زمان شما به پایان رسید.'], 404);
        }
    }


    public function verifyCode(Request $request)
    {


        $request->validate([
            'code' => 'required|digits:6',
        ]);


        if (isset($_COOKIE["mobile"])) {

            $cachedMobile = $_COOKIE["mobile"];

            $record = DB::table('verifications')
                ->where('mobile', $cachedMobile)
                ->where('code', $request->code)
                ->where('expires_at', '>=', now())
                ->first();


            if ($record) {
                $user = User::where('mobile', $cachedMobile)->first();
                if ($user) {
                    Auth::login($user);
                    return response()->json(['message' => 'احراز هویت انجام شد'], 200);
                }
            }

            return response()->json(['message' => 'کد نامعتبر است یا منقضی شده است.'], 422);
        } else {
            return response()->json(['message' => 'زمان شما به پایان رسید.'], 404);
        }
    }


    public function register(Request $request)
    {

        // $cachedMobile = Cache::get($request->cach_key);

        // $existingUser = User::where('mobile', isset($request->mobile) ? $request->mobile : $cachedMobile)->first();
        // if ($existingUser) {
        //     return response()->json(['message' => 'این شماره موبایل قبلاً تایید و ثبت شده است.'], 400);
        // }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|regex:/^[0][9][0-9]{9,9}$/',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        // Cache::forget($request->cach_key);

        return response()->json([
            'message' => 'کاربر با موفقیت ثبت نام کرد.',
            'token' => $token,
        ], 201);
    }


    public function authentication(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'error' => 'کاربر احراز هویت نشده است.',
            ], 401);
        }

        return response()->json($user, 200);
    }


    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'mobile' => 'required|regex:/^[0][9][0-9]{9,9}$/',
    //         'password' => 'required',
    //     ]);

    //     $user = User::where('mobile', $request->mobile)->first();
    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return response()->json(['message' => 'اطلاعات ورود نامعتبر است.'], 401);
    //     }

    //     $user->tokens()->delete();
    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'message' => 'ورود با موفقیت انجام شد.',
    //         'token' => $token,
    //     ]);
    // }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'خروج با موفقیت انجام شد.',
        ]);
    }


    public function resendVerificationCode(Request $request)
    {

        if (Cache::has($request->cach_key)) {
            $cachedMobile = Cache::get($request->cach_key);
            $existingUser = verification::where(['mobile' => $cachedMobile, 'status' => 1])->first();

            if ($existingUser) {
                return response()->json(['message' => 'این شماره موبایل قبلاً تایید و ثبت شده است.'], 400);
            } else {
                $code = rand(100000, 999999);

                DB::table('verifications')
                    ->where('mobile', $cachedMobile)
                    ->update([
                        'code' => $code,
                        'expires_at' => now()->addMinutes(6),
                    ]);

                Cache::put('mobile', $cachedMobile, now()->addMinutes(6));
            }
        } else {
            return response()->json(['message' => 'زمان شما به پایان رسید.'], 404);
        }



        send_sms($cachedMobile, $code);

        return response()->json(['message' => 'کد تایید با موفقیت ارسال شد.', 'code' => $code], 200);
    }
}
