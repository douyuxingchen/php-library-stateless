<?php
namespace Douyuxingchen\PhpLibraryStateless\Call;

use Douyuxingchen\PhpLibraryStateless\Quest\Http;

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

    public function create(): Zhichi
    {
        $http = new Http();
        $companyId = $this->companyId ?: env('ZHICHI_COMPANY_ID');
        return new Zhichi($this->token, $companyId, $http);
    }
}

