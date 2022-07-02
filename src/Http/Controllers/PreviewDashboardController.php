<?php

namespace Gabeta\CustomSmsChannels\Http\Controllers;

use Illuminate\Routing\Controller;

class PreviewDashboardController extends Controller
{
    public function index()
    {
        $messages = app('providers.sms_log')->read();

        $host = config('custom-sms-channels.preview.broadcasting.host');

        $port = config('custom-sms-channels.preview.broadcasting.port');

        return view('customsms::dashboard', compact('messages', 'host', 'port'));
    }

    public function smsList() 
    {
        $sms = app('providers.sms_log')->read();

        return response()->json($sms);
    }

    public function clearSms() 
    {
        $sms = app('providers.sms_log')->clear();

        return response()->json($sms);
    }
}
