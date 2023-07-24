<?php
namespace Douyuxingchen\PhpLibraryStateless\Sms;

use Douyuxingchen\PhpLibraryStateless\Quest\Http;
use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponse;
use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponseInter;

class FeigeSmsProvider implements SmsProviderInterface
{
    private $apiUrl = "https://api.4321.sh/";
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


    public function getResponse()
    {
        return $this->response;
    }

    public function send(): ThirdPartyResponseInter
    {
        $url = $this->apiUrl . "sms/send";
        return $this->request($url);
    }

    public function sendTemplate(): ThirdPartyResponseInter
    {
        $url = $this->apiUrl . "sms/template";
        return $this->request($url);
    }

    private function request($url) : ThirdPartyResponseInter
    {
        $apiRes = (new Http())->setPost()
            ->setUrl($url)
            ->setData($this->requestData)
            ->request();
        if(!$apiRes->isStatus()) {
            return $apiRes;
        }

        $this->response = $apiRes->getData();

        if (empty($this->response)) {
            return ThirdPartyResponse::create(false, '调用飞鸽api失败')->setData([
                'req' => $this->requestData,
                'res' => $this->response
            ]);
        }

        return ThirdPartyResponse::create($this->response['code'] == 0,$this->response['msg'] ?? null)
            ->setRequestId($this->response['msg_no'] ?? null)
            ->setData($this->response);
    }
}