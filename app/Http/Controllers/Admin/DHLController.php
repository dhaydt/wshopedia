<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DHLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin-views.shipping-method.dhl');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::table('business_settings')->updateOrInsert(['type' => 'dhl_parcel'], [
                'type' => 'dhl_parcel',
                'value' => json_encode([
                    'status' => $request['status'],
                    'dhl_key' => $request['dhl_key'],
                    'dhl_secret' => $request['dhl_secret'],
                    'signature_secret' => '',
                    'private_key' => '',
                    'application_id' => '',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        $config = Helpers::get_business_settings('dhl_parcel');
        DB::table('business_settings')->updateOrInsert(['type' => 'dhl_parcel'], [
                    'type' => 'dhl_parcel',
                    'value' => json_encode([
                        'status' => 0,
                        'dhl_key' => $config['dhl_key'],
                        'dhl_secret' => $config['dhl_secret'],
                        'signature_secret' => '',
                        'private_key' => '',
                        'application_id' => '',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

        return back();
    }
}