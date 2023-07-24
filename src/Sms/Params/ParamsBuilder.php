<?php
namespace Douyuxingchen\PhpLibraryStateless\Sms\Params;

use Douyuxingchen\PhpLibraryStateless\Exceptions\ValidateException;

class ParamsBuilder
{
    // 短信服务提供商
    private $provider;

    // 参数
    private $params;

    private $templateCode;

    public function setProvider(ParamsGenInterface $provider) : ParamsBuilder
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @throws ValidateException
     */
    public function build() : ParamsGenInterface
    {
        if(!$this->templateCode) {
            throw new ValidateException("not found param templateCode");
        }
        $this->provider->setParams($this->params);
        $this->provider->setTemplateCode($this->templateCode);
        return $this->provider;
    }

    public function setParams(array $params): ParamsBuilder
    {
        $this->params = $params;
        return $this;
    }

    public function setTempCode($templateCode): ParamsBuilder
    {
        $this->templateCode = $templateCode;
        return $this;
    }
}