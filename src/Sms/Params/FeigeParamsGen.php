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

    // 小小包R未进群外呼
    const KEY_NOT_GROUP = "feige_tpl4";
    const CODE_NOT_GROUP = "144524";

    // T系列课程下单通知
    const KEY_T_CLASS = 'feige_tpl5';
    const CODE_T_CLASS = '149272';

    // 渠道推广活动通知加小云
    const KEY_ACTIVE_MSG_ADD_YUN = 'feige_tpl6';
    const CODE_ACTIVE_MSG_ADD_YUN = '153482';
    const KEY_TLX_ACTIVE_MSG_ADD_YUN = 'feige_tpl7';
    const CODE_TLX_ACTIVE_MSG_ADD_YUN = '156046';

    // 模版key和code映射关系
    const KEY_CODE = [
        self::KEY_CREATE_ORDER => self::CODE_CREATE_ORDER,
        self::KEY_YUN_CREATE_ORDER => self::CODE_YUN_CREATE_ORDER,
        self::KEY_NOT_GROUP => self::CODE_NOT_GROUP,
        self::KEY_T_CLASS => self::CODE_T_CLASS,
        self::KEY_ACTIVE_MSG_ADD_YUN => self::CODE_ACTIVE_MSG_ADD_YUN,
        self::KEY_TLX_ACTIVE_MSG_ADD_YUN => self::CODE_TLX_ACTIVE_MSG_ADD_YUN,
    ];

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
            case FeigeParamsGen::CODE_NOT_GROUP:
            case FeigeParamsGen::CODE_T_CLASS:
            case FeigeParamsGen::CODE_ACTIVE_MSG_ADD_YUN:
            case FeigeParamsGen::CODE_TLX_ACTIVE_MSG_ADD_YUN:
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

    /**
     * 验证短信模版key是否合法
     *
     * @param string $templateKey
     * @return bool
     */
    public static function validateTemplateKey(string $templateKey): bool
    {
        return array_key_exists($templateKey, FeigeParamsGen::KEY_CODE);
    }
}