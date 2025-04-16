<?php

namespace App\Http\Controllers\Authenticate;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Otp;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    // check otp code and login
    public function checkotp(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'otp' => 'required|min:5|max:5',
            'mobile' => 'required|min:11|max:11'
        ]);

        if (!$validator->passes()) {
            return redirect()->back()->withErrors($validator);
        }

        try {

            $mobile = $request->mobile;
            $check_otp = Otp::where('mobile', $mobile)->orderBy('id', 'desc')->pluck('otp')->first();
            $user = Employee::where('mobile', $mobile)->first();

            if ($request->otp == $check_otp) {

                auth()->login($user);

                if (auth()->check()) {

                    Otp::where('mobile', $mobile)->delete();

                    return redirect()->route('admin.dashboard');

                } else {
                    return redirect()->route('auth.login')
                        ->withErrors('خطای داخلی رخ داد لطفا چند لحظه دیگر دوباره امتحان کنید');
                }

            } else {

                return view('auth.otp', compact('mobile'))
                    ->withErrors('کد وارد شده صحیح نمیباشد');

            }

        } catch (\Exception $e) {

            // Send the exception details to Laravel Telescope for monitoring and debugging purposes
            report( extractError($e) );

            return redirect()->route('auth.login')
                ->withErrors('خطای داخلی رخ داد لطفا چند لحظه دیگر دوباره امتحان کنید');

        }

    }

    // send otp code and return otp view
    public function sendotp(Request $request)
    {
        // validate data
        $validator = \Validator::make($request->all(), [
            'mobile' => 'required|min:11|max:11'
        ]);

        if (!$validator->passes()) {
            return redirect()->back()->withErrors($validator);
        }

        try {

            // check exists user
            $mobile = $request->mobile;
            if (!Employee::where('mobile', $mobile)->exists()) {
                return redirect()->back()->withErrors('کاربری با این مشخصات یافت نشد!');
            }

            $user = Employee::query()->where('mobile', $mobile)->first();
            if ($user->status != 1) {
                return redirect()->route('auth.login')->withErrors('متاسفانه حساب کاربری شما مسدود میباشد جهت پیگیری با پشتیبانی در ارتباط باشید');
            }

            // Quick login
            if ($mobile == "09122222222") {
                $code = 77777;
            } else {
                // generate and send sms otp code
                $code = rand(10000, 99999);
                $this->sendSms($mobile, $code, 'cargo-otp');
            }

            // save otp code in database
            $otp = Otp::insert(array(
                'mobile' => $mobile,
                'otp' => $code,
            ));

            // return otp code page
            if ($otp) {
                return view('auth.otp', compact('mobile'));
            }
            return redirect()->back()->withErrors('خطای داخلی رخ داده است لطفا چند لحظه دیگر دوباره تلاش کنید');

        } catch (\Exception $e) {

            // Send the exception details to Laravel Telescope for monitoring and debugging purposes
            report( extractError($e) );

            return redirect()->back()->withErrors('خطای داخلی رخ داده است لطفا چند لحظه دیگر دوباره تلاش کنید');

        }

    }

    // show login form
    public function adminlogin()
    {
        if (Auth::check())
            return redirect()->back();
        else
            return view('auth.mobile');
    }

    public function sendSms($phone, $token, $template = 'verify', $token2 = '', $token3 = '')
    {

        for ($i = 0; $i < 3; $i++) {

            $url = "https://api.kavenegar.com/v1/" . config('services.kavenegar.token') . "/verify/lookup.json";

            $response = Http::withoutVerifying()->post($url, [
                'receptor' => $phone,
                'token' => $token,
                'token2' => $token2,
                'token3' => $token3,
                'template' => $template,
            ]);

            $data = $response->json();

            if ($data['return']['status'] == 200)
                break;

        }

//
//        $url = "https://api.kavenegar.com/v1/" . config('services.kavenegar.token') . "/verify/lookup.json?receptor=$phone&token=$token&token2=$token2&token3=$token3&template=$template";
//        return (new Client())->get($url);
    }

    public function logout()
    {
        Auth::logout();

        return redirect(route('index'));
    }

}
