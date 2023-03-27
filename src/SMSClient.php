<?php

namespace Raahin\Aban;

use Illuminate\Support\Facades\Http;

class SMSClient
{
    private $baseUrl;

    private $http;

    public function __construct()
    {
        $this->baseUrl = config('aban.baseSMSWrapperUrl',"https://sms-wrapper-uat.k8s.daan.ir");
    }

    public function setHttp(array $array = [])
    {
        $this->http = Http::withHeaders($array);
        return $this;
    }

    public function setApiKeyHttpHeader($apiKey)
    {
        $this->http = Http::withHeaders([
            'X-API-KEY' => $apiKey,
        ]);
        return $this;
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function preparePhoneNumber($mobile)
    {
        if(substr($mobile,0,23)=="+98")
        {
            $mobile = str_replace("+","",$mobile);
        }
        if(substr($mobile,0,1)=="0")
        {
            $mobile =  ltrim($mobile, $mobile[0]);
        }
        if(substr($mobile,0,2) != "98")
        {
            $mobile = ("98" . $mobile);
        }
        return $mobile; 
    }

    public function	sendSingleSMS($phone_number, string $message, $sms_service_id = "4")
    {
        $response = $this->http->post("$this->baseUrl/api/v1/sms/send?sms_service_id={$sms_service_id}",[
            "msisdn" => $this->preparePhoneNumber($phone_number),
            "message" => $message,
        ]);
        return $response;
    }
}