<?php
namespace Tests\Feature\Sms;

use Douyuxingchen\PhpLibraryStateless\Sms\Params\FeigeParamsGen;
use Douyuxingchen\PhpLibraryStateless\Sms\Params\ParamsBuilder;
use PHPUnit\Framework\TestCase;

class FeigeParamsTest extends TestCase
{
    public function testFeigeParams()
    {
        $res = (new ParamsBuilder())->setProvider(new FeigeParamsGen())
            ->setParams(['link' => 'https://www.baidu.com'])
            ->setTempCode(FeigeParamsGen::CODE_YUN_CREATE_ORDER)
            ->build()
            ->genParams();
        $this->assertEquals("https://www.baidu.com", $res);
    }

    public function testFeigeParamsTrue()
    {
        $res = FeigeParamsGen::validateTemplateKey('feige_tpl2');
        $this->assertTrue($res);
    }

    public function testFeigeParamsFalse()
    {
        $res = FeigeParamsGen::validateTemplateKey('test666');
        $this->assertFalse($res);
    }

}