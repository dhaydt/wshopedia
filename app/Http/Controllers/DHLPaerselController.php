<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;

class DHLPaerselController extends Controller
{
    public function __construct()
    {
        $dhl_conf = Config::get('dhl');
        $id = $dhl_conf['key'];
              $key  $dhl_conf['secret'];
        $dhlparcel = new \Mvdnbrk\DhlParcel\Client();

        $dhlparcel->setUserId('your-user-id');
        $dhlparcel->setApiKey('your-api-key');

    }
}