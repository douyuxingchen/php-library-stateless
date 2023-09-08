<?php
namespace Tests\Unit;

use Douyuxingchen\PhpLibraryStateless\FeigeSms\SmsBuilder;
use PHPUnit\Framework\TestCase;

class FeigeTest extends TestCase
{
    public function testSendSms()
    {
        $smsBuilder = new SmsBuilder();
        $sms = $smsBuilder->setMobile('15711273395')
            ->setSignId(185283)
            ->setExtNo("666")
            ->setContent('测试短信，点击此链接{link}领取{amount}元大礼包')
            ->setParams(['link' => 'https://www.baidu.com', 'amount' => '100'])
            ->build();

        // 只有在测试环境才需要自定义key
        $sms->setApikey(getenv('FEIGE_APIKEY'))->setSecret(getenv('FEIGE_SECRET'));

        $res = $sms->send();

        $this->assertEquals(true, $res->isStatus());

    }

//    public function testSendTempSms()
//    {
//
//    }


}