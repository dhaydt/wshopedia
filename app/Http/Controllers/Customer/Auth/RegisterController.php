<?php

namespace App\Http\Controllers\Customer\Auth;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\CPU\SMS_module;
use function App\CPU\translate;
use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\PhoneOrEmailVerification;
use App\Model\Wishlist;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Session;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer', ['except' => ['logout']]);
    }

    public function register()
    {
        session()->put('keep_return_url', url()->previous());
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => config('rajaongkir.url').'/province',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'key:'.config('rajaongkir.api_key'),
            ],
        ]);

        $resp = curl_exec($curl);
        $err = curl_error($curl);
        $resp = json_decode($resp, true);
        $prov = $resp['rajaongkir']['results'];

        // dd($prov);

        curl_close($curl);

        if ($err) {
            echo 'cURL Error #:'.$err;
        } else {
            return view('customer-view.auth.register', ['prov' => $prov]);
        }
    }

    public function getCity($id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => config('rajaongkir.url').'/city?&province='.$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'key:'.config('rajaongkir.api_key'),
            ],
        ]);

        $resp = curl_exec($curl);
        $err = curl_error($curl);
        $resp = json_decode($resp, true);
        $data = $resp['rajaongkir']['results'];

        // dd($prov);

        curl_close($curl);

        if ($err) {
            echo 'cURL Error #:'.$err;
        } else {
            return $data;
        }
    }

    public function submit(Request $request)
    {
        // dd($request);
        $user = User::where('email', $request->email)->orWhere('phone', $request->phone)->first();
        if (isset($user) && $user->is_phone_verified == 0 && $user->is_email_verified == 0) {
            return redirect(route('customer.auth.check', [$user->id]));
        }

        $request->validate([
            'f_name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'unique:users',
            'password' => 'required|min:8|same:con_password',
        ],
            [
                'f_name.required' => 'First name is required',
                'address.required' => 'Address name is required',
                'country.required' => 'Country name is required',
                'province.required' => 'Province name is required',
                'city.required' => 'City name is required',
            ]);

        if ($request['country'] == 'indonesia' || $request['country'] == 'Indonesia') {
            $provin = $request['province'];
            $provins = explode(',', $provin);
            $prov_id = $provins[0];
            $prov = $provins[1];

            $cities = $request['city'];
            $cit = explode(',', $cities);
            $city_id = $cit[0];
            $city = $cit[1];
        } else {
            $prov = $request['province'];
            $prov_id = '0';

            $city = $request['city'];
            $city_id = '0';
        }

        $fn = $request['f_name'];
        $ln = $request['l_name'];
        $add = $request['address'];
        $country = $request['country'];
        $email = $request['email'];
        $phone = $request['phone'];
        // dd($prov_id, $prov, $city_id, $city);

        $user = User::create([
            'f_name' => $fn,
            'l_name' => $ln,
            'address' => $add,
            'country' => $country,
            'prov_id' => $prov_id,
            'province' => $prov,
            'city_id' => $city_id,
            'city' => $city,
            'email' => $email,
            'phone' => $phone,
            'is_active' => 1,
            'password' => bcrypt($request['password']),
        ]);

        $user_id = User::latest()->first();
        // dd($user_id);
        $address = [
            'customer_id' => $user_id['id'],
            'contact_person_name' => $fn.' '.$ln,
            'address_type' => 'home',
            'address' => $add,
            'city' => $city,
            'city_id' => $city_id,
            // 'zip' => $request->zip,
            'phone' => $phone,
            'state' => $prov,
            'state_id' => $prov_id,
            'country' => $country,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shipping_addresses')->insert($address);

        $phone_verification = Helpers::get_business_settings('phone_verification');
        $email_verification = Helpers::get_business_settings('email_verification');
        if ($phone_verification && !$user->is_phone_verified) {
            return redirect(route('customer.auth.check', [$user->id]));
        }
        if ($email_verification && !$user->is_email_verified) {
            return redirect(route('customer.auth.check', [$user->id]));
        }

        Toastr::success(translate('registration_success_login_now'));

        return redirect(route('customer.auth.login'));
    }

    public static function check($id)
    {
        $user = User::find($id);

        $token = rand(1000, 9999);
        DB::table('phone_or_email_verifications')->insert([
            'phone_or_email' => $user->email,
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $phone_verification = Helpers::get_business_settings('phone_verification');
        $email_verification = Helpers::get_business_settings('email_verification');
        if ($phone_verification && !$user->is_phone_verified) {
            SMS_module::send($user->phone, $token);
            $response = translate('please_check_your_SMS_for_OTP');
            Toastr::success($response);
        }
        if ($email_verification && !$user->is_email_verified) {
            try {
                Mail::to($user->email)->send(new \App\Mail\EmailVerification($token));
                $response = translate('check_your_email');
                Toastr::success($response);
            } catch (\Exception $exception) {
                $response = translate('email_failed');
                Toastr::error($response);
            }
        }

        return view('customer-view.auth.verify', compact('user'));
    }

    public static function verify(Request $request)
    {
        Validator::make($request->all(), [
            'token' => 'required',
        ]);

        $email_status = BusinessSetting::where('type', 'email_verification')->first()->value;
        $phone_status = BusinessSetting::where('type', 'phone_verification')->first()->value;

        $user = User::find($request->id);
        $verify = PhoneOrEmailVerification::where(['phone_or_email' => $user->email, 'token' => $request['token']])->first();

        if ($email_status == 1 || ($email_status == 0 && $phone_status == 0)) {
            if (isset($verify)) {
                try {
                    $user->is_email_verified = 1;
                    $user->save();
                    $verify->delete();
                } catch (\Exception $exception) {
                    Toastr::info('Try again');
                }

                Toastr::success(translate('verification_done_successfully'));
            } else {
                Toastr::error(translate('Verification_code_or_OTP mismatched'));

                return redirect()->back();
            }
        } else {
            if (isset($verify)) {
                try {
                    $user->is_phone_verified = 1;
                    $user->save();
                    $verify->delete();
                } catch (\Exception $exception) {
                    Toastr::info('Try again');
                }

                Toastr::success('Verification Successfully Done');
            } else {
                Toastr::error('Verification code/ OTP mismatched');
            }
        }

        return redirect(route('customer.auth.login'));
    }

    public static function login_process($user, $email, $password)
    {
        if (auth('customer')->attempt(['email' => $email, 'password' => $password], true)) {
            session()->put('wish_list', Wishlist::where('customer_id', $user->id)->pluck('product_id')->toArray());
            $company_name = BusinessSetting::where('type', 'company_name')->first();
            $message = 'Welcome to '.$company_name->value.'!';
            CartManager::cart_to_db();
        } else {
            $message = 'Credentials are not matched or your account is not active!';
        }

        return $message;
    }
}