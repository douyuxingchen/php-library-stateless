<?php
namespace Douyuxingchen\PhpLibraryStateless\Sms\Params;

class TencentParamsGen implements ParamsGenInterface
{
    private $params;
    private $templateCode;

    public function setParams(array $params): ParamsGenInterface
    {
        $this->params = $params;
        return $this;
    }

    public function setTemplateCode($templateCode) : ParamsGenInterface
    {
        $this->templateCode = $templateCode;
        return $this;
    }

    public function genParams() {
        // 根据腾讯云短信模版规则生成参数
        // 具体实现省略，这里假设直接返回参数列表
        return $this->params;
    }
}