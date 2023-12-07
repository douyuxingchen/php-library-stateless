<?php
namespace Tests\Unit\Sms;

use Douyuxingchen\PhpLibraryStateless\Sms\FeigeSmsProvider;
use Douyuxingchen\PhpLibraryStateless\Sms\Params\FeigeParamsGen;
use Douyuxingchen\PhpLibraryStateless\Sms\Params\ParamsBuilder;
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

    // 测试
    // 模版短信 - T系列课程下单通知
    public function testSendTempTClass()
    {
        $temp_code = '149272';

        $sms = (new SmsBuilder())->setProvider(new FeigeSmsProvider())
            ->setMobile('15711273395')
            ->setSignId(185283)
            ->setExtNo("666")
            ->setTemplateId($temp_code)
            ->setContent('T系列课程')
            ->setSendTime()
            ->build();

        $sms->setEnv([
            'apikey' => lib_env('FEIGE_APIKEY'),
            'secret' => lib_env('FEIGE_SECRET'),
        ]);

        $res = $sms->sendTemplate();

        if(!$res->isStatus()) {
            var_dump($res->getMessage());
            var_dump($res->getData());
        }

        $this->assertEquals(true, $res->isStatus());
    }

    // 测试
    // 模版短信 - 渠道推广活动通知加小云
    // ./vendor/bin/phpunit --filter testActiveMsgAddYun ./tests/Unit/Sms/FeigeSmsTest.php
    public function testActiveMsgAddYun()
    {
        $temp_code = FeigeParamsGen::CODE_ACTIVE_MSG_ADD_YUN;

        $sms = (new SmsBuilder())->setProvider(new FeigeSmsProvider())
            ->setMobile('15711273395')
            ->setSignId(185283)
            ->setExtNo("666")
            ->setTemplateId($temp_code)
            ->setContent('我是测试链接')
            ->setSendTime()
            ->build();

        $sms->setEnv([
            'apikey' => lib_env('FEIGE_APIKEY'),
            'secret' => lib_env('FEIGE_SECRET'),
        ]);

        $res = $sms->sendTemplate();

        if(!$res->isStatus()) {
            var_dump($res->getMessage());
            var_dump($res->getData());
        }

        $this->assertEquals(true, $res->isStatus());
    }

    // 测试
    // 模版短信 - 渠道推广活动通知加小云
    // ./vendor/bin/phpunit --filter testActiveMsgAddYun2 ./tests/Unit/Sms/FeigeSmsTest.php
    public function testActiveMsgAddYun2()
    {
        $smsTemplateKey = FeigeParamsGen::KEY_ACTIVE_MSG_ADD_YUN;
        $params['link'] = 'https://www.yunkeyouxuan.com';

        $content = (new ParamsBuilder())->setProvider(new FeigeParamsGen())
                ->setParams([
                    'link' => $params['link'] ?? null,
                ])->setTempCode(FeigeParamsGen::KEY_CODE[$smsTemplateKey])
                ->build()
                ->genParams();

        $sms = (new SmsBuilder())->setProvider(new FeigeSmsProvider())
            ->setMobile('15711273395')
            ->setSignId(185283)
            ->setExtNo("666")
            ->setTemplateId(FeigeParamsGen::KEY_CODE[$smsTemplateKey])
            ->setContent($content)
            ->setSendTime()
            ->build();

        $sms->setEnv([
            'apikey' => lib_env('FEIGE_APIKEY'),
            'secret' => lib_env('FEIGE_SECRET'),
        ]);

        $res = $sms->sendTemplate();

        if(!$res->isStatus()) {
            var_dump($res->getMessage());
            var_dump($res->getData());
        }

        $this->assertEquals(true, $res->isStatus());
    }

    // 测试
    // 模版短信 - 考书大课报名Z50系列报名通知
    // ./vendor/bin/phpunit --filter testActiveMsgBookZ50 ./tests/Unit/Sms/FeigeSmsTest.php
    public function testActiveMsgBookZ50()
    {
        $smsTemplateKey = FeigeParamsGen::KEY_BOOK_Z50;

        $content = (new ParamsBuilder())->setProvider(new FeigeParamsGen())
                ->setParams([
                    'link' =>  null,
                ])->setTempCode(FeigeParamsGen::KEY_CODE[$smsTemplateKey])
                ->build()
                ->genParams();

        $sms = (new SmsBuilder())->setProvider(new FeigeSmsProvider())
            ->setMobile('15711273395')
            ->setSignId(185283)
            ->setExtNo("666")
            ->setTemplateId(FeigeParamsGen::KEY_CODE[$smsTemplateKey])
            ->setContent($content)
            ->setSendTime()
            ->build();

        $sms->setEnv([
            'apikey' => lib_env('FEIGE_APIKEY'),
            'secret' => lib_env('FEIGE_SECRET'),
        ]);

        $res = $sms->sendTemplate();

        if(!$res->isStatus()) {
            var_dump($res->getMessage());
            var_dump($res->getData());
        }

        $this->assertEquals(true, $res->isStatus());
    }

}