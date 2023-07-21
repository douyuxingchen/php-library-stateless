<?php
namespace Douyuxingchen\PhpLibraryStateless\ShortMessage;

class SmsBuilder {

    // 短信服务提供商
    private $provider;

    // 请求参数
    private $requestData = [];

    /**
     * [必须] 短信服务商
     *
     * @param SmsProviderInterface $provider
     * @return $this
     */
    public function setProvider(SmsProviderInterface $provider): SmsBuilder
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * [必须] 获取（构造/建造）对象
     *
     * @return SmsProviderInterface
     */
    public function build(): SmsProviderInterface
    {
        $this->provider->setRequest($this->getRequest());
        return $this->provider;
    }

    public function setMobile(string $mobile): SmsBuilder
    {
        $this->requestData['mobile'] = $mobile;
        return $this;
    }

    public function setSignId(int $sign_id): SmsBuilder
    {
        $this->requestData['sign_id'] = $sign_id;
        return $this;
    }

    public function setSign(string $sign): SmsBuilder
    {
        $this->requestData['sign'] = $sign;
        return $this;
    }

    public function setExtNo(string $ext_no): SmsBuilder
    {
        $this->requestData['ext_no'] = $ext_no;
        return $this;
    }

    public function setTemplateId(string $templateId): SmsBuilder
    {
        $this->requestData['template_id'] = $templateId;
        return $this;
    }

    public function setContent($content): SmsBuilder
    {
        $this->requestData['content'] = $content;
        return $this;
    }

    public function setParams(array $params): SmsBuilder
    {
        if($this->provider instanceof FeigeSmsProvider) {
            foreach ($params as $key => $value) {
                $this->requestData['content'] = str_replace('{'. $key .'}', $value, $this->requestData['content']);
            }
        }
        return $this;
    }

    public function setSendTime(): SmsBuilder
    {
        $this->requestData['send_time'] = time();
        return $this;
    }

    public function getRequest(): array
    {
        // 数据生成
        // ... ...

        // 数据校验
        // ... ...

        // 赋值
        return $this->requestData;
    }



}