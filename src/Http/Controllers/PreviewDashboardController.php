<?php

namespace Gabeta\CustomSmsChannels\Http\Controllers;

use Illuminate\Routing\Controller;

class PreviewDashboardController extends Controller
{
    public function index()
    {
        $messages = app('providers.sms_log')->read();

        return view('customsms::dashboard', compact('messages'));
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
