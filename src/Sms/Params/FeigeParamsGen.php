<?php
namespace Douyuxingchen\PhpLibraryStateless\Sms\Params;

use Douyuxingchen\PhpLibraryStateless\Exceptions\ValidateException;

class FeigeParamsGen implements ParamsGenInterface
{
    // 下单后的通用通知模板
    const KEY_CREATE_ORDER = "feige_tpl1";
    const CODE_CREATE_ORDER = "143943";

    // 下单后添加R系列小云的通用通知
    const KEY_YUN_CREATE_ORDER = "feige_tpl2";
    const CODE_YUN_CREATE_ORDER = "143874";

    private $params = [];
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

    /**
     * @throws ValidateException
     */
    public function genParams() {
        switch ($this->templateCode){
            case FeigeParamsGen::CODE_CREATE_ORDER:
            case FeigeParamsGen::CODE_YUN_CREATE_ORDER:
                if(!isset($this->params['link'])) {
                    throw new ValidateException("not found param link");
                }
                $data = [
                    'link' => $this->params['link'],
                ];
                $data = implode('|', $data);
                break;
            default:
                return [];
        }

        return $data;
    }
}