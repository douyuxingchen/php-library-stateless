<?php
namespace Douyuxingchen\PhpLibraryStateless\FeigeSms;

/**
 * @deprecated 该类库已经弃用，后续不再维护，请使用新方法
 * @see \Douyuxingchen\PhpLibraryStateless\ShortMessage\SmsBuilder;
 *
 * @return SmsBuilder
 */
class SmsBuilder {

    private $requestData = [];

    public function setMobile(string $mobile): self
    {
        $this->requestData['mobile'] = $mobile;
        return $this;
    }

    public function setSignId(int $sign_id): self
    {
        $this->requestData['sign_id'] = $sign_id;
        return $this;
    }

    public function setSign(string $sign): self
    {
        $this->requestData['sign'] = $sign;
        return $this;
    }

    public function setExtNo(string $ext_no): self
    {
        $this->requestData['ext_no'] = $ext_no;
        return $this;
    }

    public function setTemplateId(string $templateId): self
    {
        $this->requestData['template_id'] = $templateId;
        return $this;
    }

    public function setContent($content): self
    {
        $this->requestData['content'] = $content;
        return $this;
    }

    public function setParams(array $params): self
    {
        foreach ($params as $key => $value) {
            $this->requestData['content'] = str_replace('{'. $key .'}', $value, $this->requestData['content']);
        }
        // $this->requestData['params'] = $params;
        return $this;
    }

    public function getRequest(): array
    {
        // 数据生成
        $this->requestData['send_time'] = time();

        // TODO 数据校验
        // ...

        // 赋值
        return $this->requestData;
    }

    /**
     * 建造sms对象
     *
     * @return Sms
     */
    public function build(): Sms
    {
        return new Sms($this->getRequest());
    }

}