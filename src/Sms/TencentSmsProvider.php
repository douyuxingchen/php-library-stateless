<?php
namespace Douyuxingchen\PhpLibraryStateless\Sms;

use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponse;
use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponseInter;

class TencentSmsProvider implements SmsProviderInterface
{
    private $apiUrl = "xxxxx";
    private $requestData;
    private $response;

    public function setRequest(array $requestData) : SmsProviderInterface
    {
        $this->requestData = $requestData;
        // 定义密钥
        $this->requestData['apikey'] = env('FEIGE_APIKEY');
        $this->requestData['secret'] = env('FEIGE_SECRET');
        return $this;
    }

    public function setEnv(array $env) : SmsProviderInterface
    {
        $this->requestData['apikey'] = $env['apikey'];
        $this->requestData['secret'] = $env['secret'];
        return $this;
    }

    public function getRequest() : array
    {
        return $this->requestData;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function send(): ThirdPartyResponseInter
    {
        return new ThirdPartyResponse(false, '未开发');
    }

    public function sendTemplate(): ThirdPartyResponseInter
    {
        return new ThirdPartyResponse(false, '未开发');
    }


}