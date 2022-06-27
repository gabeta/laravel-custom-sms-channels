<?php


namespace Gabeta\CustomSmsChannels\Http\Controllers;


use Illuminate\Routing\Controller;

class SmsListController extends Controller
{
    public function __invoke()
    {
        $sms = app('providers.sms_log')->readContent();

        return response()->json($sms);
    }
}
