<?php

namespace App\Services;

use App\Extra\MainTrait;
use App\Models\Admin\Campaign;
use App\Models\Sms_email_templates;
use App\Models\Societies;
use Exception;

class smsService
{

    use MainTrait;


    function send_sms($user, $type, $shortCodes = [])
    {
        $general = Societies::first(['sms_config']);
        $sms_template = Sms_email_templates::where('action', $type)->where('sms_status', 1)->first();
        if ($sms_template) {
            $template = $sms_template->sms_body;

            foreach ($shortCodes as $code => $value) {
                $template = $this->shortCodeReplacer('{{' . $code . '}}', $value, $template);
            }
            $template = urlencode($template);

            $message = $this->shortCodeReplacer("{{number}}", "973".$user->phone, $general->sms_config);
            $message = $this->shortCodeReplacer("{{message}}", $template, $message);
            $result = @file_get_contents($message);
        }
    }


    function shortCodeReplacer($shortCode, $replace_with, $template_string)
    {
        return str_replace($shortCode, $replace_with, $template_string);
    }


}
