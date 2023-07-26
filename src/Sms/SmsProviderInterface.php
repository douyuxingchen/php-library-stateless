<?php
namespace Douyuxingchen\PhpLibraryStateless\Sms;

use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponseInter;

interface SmsProviderInterface
{
    /**
     * 请求参数
     *
     * @param array $requestData
     * @return self
     */
    public function setRequest(array $requestData) : SmsProviderInterface;

    /**
     * 定义环境信息
     * 仅供本类库单元测试使用，该方法不给业务提供服务
     *
     * @param array $env
     * @return self
     */
    public function setEnv(array $env) : SmsProviderInterface;

    /**
     * 发送普通短信
     *
     * @return ThirdPartyResponseInter
     */
    public function send() : ThirdPartyResponseInter;

    /**
     * 发送模版短信
     *
     * @return ThirdPartyResponseInter
     */
    public function sendTemplate() : ThirdPartyResponseInter;

    /**
     * 获取请求参数
     *
     * @return array
     */
    public function getRequest() : array;

    /**
     * 获取响应参数
     *
     * @return mixed
     */
    public function getResponse();

}