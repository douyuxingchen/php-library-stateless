<?php
namespace Douyuxingchen\PhpLibraryStateless\Call;

use Douyuxingchen\PhpLibraryStateless\Exceptions\Exception;
use Douyuxingchen\PhpLibraryStateless\Quest\Http;
use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponse;
use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponseInter;

class ZhichiFactory {

    private $token;
    private $companyId;

    /**
     * 定义token
     *
     * @param string $token
     * @return $this
     */
    public function setToken(string $token): ZhichiFactory
    {
        $this->token = $token;
        return $this;
    }

    /**
     * 自定义企业ID
     *
     * @param string $companyId
     * @return $this
     */
    public function setCompanyId(string $companyId): ZhichiFactory
    {
        $this->companyId = $companyId;
        return $this;
    }

    /**
     * 获取API的token
     *
     * @param $apiKey
     * @param $apiSecret
     * @return ThirdPartyResponseInter
     */
    public function getToken($apiKey = null, $apiSecret = null) : ThirdPartyResponseInter
    {
        $response = (new Http())->setGet()->setUrl(Zhichi::API_URL . 'tokens')
            ->setData([
                'apiKey' => $apiKey ?: env('ZHICHI_KEY'),
                'apiSecret' => $apiSecret ?: env('ZHICHI_SECRET'),
            ])
            ->request();

        if (!$response->isStatus()) {
            return $response;
        }

        $apiRes = $response->getData();

        if (!isset($apiRes['code'])) {
            return ThirdPartyResponse::create(false, "api返回异常")->setData((array)$apiRes);
        }

        if ($apiRes['code'] != Zhichi::API_SUCCESS_CODE) {
            return ThirdPartyResponse::create(false, "api调用失败")->setData($apiRes);
        }

        return ThirdPartyResponse::create(true)->setData([
            'token' => $apiRes['content']['accessToken']
        ]);
    }

    public function create(): Zhichi
    {
        $http = new Http();
        $companyId = $this->companyId ?: env('ZHICHI_COMPANY_ID');
        return new Zhichi($this->token, $companyId, $http);
    }
}

