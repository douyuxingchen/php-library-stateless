<?php
namespace Tests\Feature\Sms;

use Douyuxingchen\PhpLibraryStateless\Exceptions\Exception;
use Douyuxingchen\PhpLibraryStateless\Sms\FeigeSmsProvider;
use Douyuxingchen\PhpLibraryStateless\Sms\SmsBuilder;
use PHPUnit\Framework\TestCase;

class FeigeSmsTest extends TestCase
{
    // 验证普通短信发送
    public function testSend()
    {
        $sms = (new SmsBuilder())->setProvider(new FeigeSmsProvider())
            ->setMobile('15711273395')
            ->setSignId(185283)
            ->setExtNo("666")
            ->setContent('测试短信，点击此链接 {link} 领取 {amount} 元大礼包')
            ->setParams(['link' => 'https://www.baidu.com', 'amount' => '100'])
            ->setSendTime()
            ->build();
        // 只有在测试环境才需要自定义key
        $sms->setEnv([
            'apikey' => lib_env('FEIGE_APIKEY'),
            'secret' => lib_env('FEIGE_SECRET'),
        ]);

        $res = $sms->send();

        if(!$res->isStatus()) {
            var_dump('FEIGE_APIKEY', lib_env('FEIGE_APIKEY'));
        }

        $this->assertEquals(true, $res->isStatus());
    }

    // 验证模版短信发送
    public function testSendTemp()
    {
        $sms = (new SmsBuilder())->setProvider(new FeigeSmsProvider())
            ->setMobile('15711273395')
            ->setSignId(185283)
            ->setExtNo("666")
            ->setTemplateId('143874')
            ->setContent('大礼包|100|快速到达')
            ->setSendTime()
            ->build();

        // 只有在测试环境才需要自定义key
        $sms->setEnv([
            'apikey' => lib_env('FEIGE_APIKEY'),
            'secret' => lib_env('FEIGE_SECRET'),
        ]);

        $res = $sms->sendTemplate();

        $this->assertEquals(true, $res->isStatus());
    }

}