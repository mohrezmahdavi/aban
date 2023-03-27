<?php

namespace Raahin\Aban;

use Illuminate\Support\Facades\Http;

class SSOClient
{
    private $baseUrl;

    private $http;

    private $secretKey;

    private $apiKey;

    public function __construct()
    {

        $this->baseUrl = config('aban.baseUrl',"https://sso-v2.aanplatform.com");

    }

    public function setHttp(array $array = [])
    {
        $this->http = Http::withHeaders($array);
        return $this;
    }

    public function setApiKeyHttpHeader($apiKey)
    {
        $this->http = Http::withHeaders([
            'x-api-key' => $apiKey,
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

    public function registerUserWithMobile($mobile, $nationalCode = '1')
    {
        $this->http->post("$this->baseUrl/sso/api/v4/users/register",[
            "mobile" => $this->preparePhoneNumber($mobile),
            "nationalCode" => $nationalCode
        ]);
        return $this;
    }

    public function registerUserWithParentMobileAndUsername($username, $parentMobile, $nationalCode = '1')
    {
        $this->http->post("$this->baseUrl/sso/api/v4/users/register",[
            "username" => $username,
            "parentMobile" => $this->preparePhoneNumber($parentMobile),
            "nationalCode" => $nationalCode
        ]);
        return $this;
    }

    public function registerUserWithParentEmailAndUsername($username, $parentEmail, $nationalCode = '1')
    {
        $this->http->post("$this->baseUrl/sso/api/v4/users/register",[
            "username" => $username,
            "parentemail" => $parentEmail,
            "nationalCode" => $nationalCode
        ]);
        return $this;
    }

    public function registerUserWithEmail($email, $nationalCode = '1')
    {
        $this->http->post("$this->baseUrl/sso/api/v4/users/register",[
            "email" => $email,
            "nationalCode" => $nationalCode
        ]);
        return $this;
    }

    public function registerUserWithUsernameAndPassword($username, $password, $nationalCode = '1')
    {
        $this->http->post("$this->baseUrl/sso/api/v4/users/register",[
            "username" => $username,
            "password" => $password,
            "nationalCode" => $nationalCode
        ]);
        return $this;
    }

    public function loginGenerateOTPWithMobile($mobile)
    {
        return $this->http->post("$this->baseUrl/sso/api/v4/users/login/generate", [
            "mobile" => $this->preparePhoneNumber($mobile),
        ]);
    }

    public function loginGenerateOTPWithParentMobileNumberAndUsername($parentMobile, $username)
    {
        return $this->http->post("$this->baseUrl/sso/api/v4/users/login/generate", [
            "username" => $username,
            "parentMobile" => $this->preparePhoneNumber($parentMobile)
        ]);
    }

    public function loginGenerateOTPWithEmail($email)
    {
        return $this->http->post("$this->baseUrl/sso/api/v4/users/login/generate", [
            "email" => $email
        ]);
    }

    public function loginGenerateOTPWithParentEmailAndUsername($parentEmail, $username)
    {
        return $this->http->post("$this->baseUrl/sso/api/v4/users/login/generate", [
            "username" => $username,
            "parentEmail" => $parentEmail     
        ]);
    }

    public function loginVerifyOTPWithMobile($mobile , $otp, $device_id = "123123123")
    {
        return $this->http->post("$this->baseUrl/sso/api/v4/users/login/verify", [
            "mobile" => $this->preparePhoneNumber($mobile),
            "otp" => $otp,
            "device_id" => $device_id
        ]);
    }

    public function loginVerifyOTPWithUsernameAndParentMobileNumber($username, $parentMobile , $otp, $device_id = "123123123")
    {
        return $this->http->post("$this->baseUrl/sso/api/v4/users/login/verify", [
            "username" => $username,
            "parentMobile" => $this->preparePhoneNumber($parentMobile),
            "otp" => $otp,
            "device_id" => $device_id
        ]);
    }

    public function loginVerifyOTPWithEmail($email , $otp, $device_id = "123123123")
    {
        return $this->http->post("$this->baseUrl/sso/api/v4/users/login/verify", [
            "email" => $email,
            "otp" => $otp,
            "device_id" => $device_id
        ]);
    }

    public function loginVerifyOTPWithUsernameAndParentEmail($username, $parentemail, $otp, $device_id = "123123123")
    {
        return $this->http->post("$this->baseUrl/sso/api/v4/users/login/verify", [
            "username" => $username,
            "parentemail" => $parentemail,
            "otp" => $otp,
            "device_id" => $device_id
        ]);
    }

    public function loginWithUsernameAndPassword($username, $password, $device_id = "123123123")
    {
        return $this->http->post("$this->baseUrl/sso/api/v4/users/login/verify", [
            "username" => $username,
            "password" => $password,
            "device_id" => $device_id
        ]);
    }

    public function relogin($refreshToken)
    {
        return $this->http->post("$this->baseUrl/sso/api/v4/users/relogin", [
            "refreshToken" => $refreshToken,
        ]);
    }

    public function logout()
    {
        return $this->http->post("$this->baseUrl/sso/api/v4/users/logout");
    }

    public function validate()
    {
        return $this->http->post("$this->baseUrl/sso/api/v4/users/validate");
    }
}