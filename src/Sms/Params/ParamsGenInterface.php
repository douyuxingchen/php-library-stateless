<?php
namespace Douyuxingchen\PhpLibraryStateless\Sms\Params;

interface ParamsGenInterface
{
    /**
     * 根据模版ID生成参数
     *
     * @return mixed
     */
    public function genParams();

    public function setParams(array $params) : ParamsGenInterface;

    public function setTemplateCode($templateCode) : ParamsGenInterface;
}