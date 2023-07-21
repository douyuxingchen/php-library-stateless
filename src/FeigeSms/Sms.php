<?php
namespace Douyuxingchen\PhpLibraryStateless\FeigeSms;

use Douyuxingchen\PhpLibraryStateless\Exceptions\ExceptionHandler;
use Douyuxingchen\PhpLibraryStateless\HttpQuest\Http;
use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponse;
use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponseInter;

class Sms
{
    private $apiUrl = "https://api.4321.sh/";

    private $requestData;

    private $response;

    public function __construct(array $requestData)
    {
        $this->requestData = $requestData;

        // 定义密钥
        $this->requestData['apikey'] = env('FEIGE_APIKEY');
        $this->requestData['secret'] = env('FEIGE_SECRET');
    }

    public function setApikey(string $apikey): self
    {
        $this->requestData['apikey'] = $apikey;
        return $this;
    }

    public function setSecret(string $secret): self
    {
        $this->requestData['secret'] = $secret;
        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    /**
     * 发送普通短信
     *
     * @return ThirdPartyResponseInter
     */
    public function send()
    {
        $url = $this->apiUrl . "sms/send";
        return $this->request($url);
    }

    /**
     * 发送模版短信
     *
     * @return ThirdPartyResponseInter
     */
    public function sendTemplate() : ThirdPartyResponseInter
    {
        $url = $this->apiUrl . "sms/template";

        return $this->request($url);
    }

    private function request($url) : ThirdPartyResponseInter
    {
        $http = new Http();
        $apiRes = $http->setPost()
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