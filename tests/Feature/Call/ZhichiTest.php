<?php
namespace Tests\Feature\Call;

use Douyuxingchen\PhpLibraryStateless\Call\Zhichi;
use Douyuxingchen\PhpLibraryStateless\Call\ZhichiFactory;
use Douyuxingchen\PhpLibraryStateless\Exceptions\Exception;
use Douyuxingchen\PhpLibraryStateless\Exceptions\ValidateException;
use Douyuxingchen\PhpLibraryStateless\Quest\Http;
use PHPUnit\Framework\TestCase;

class ZhichiTest extends TestCase
{
    // 测试获取机器人数量
    public function testRobotNum()
    {
        $res = (new ZhichiFactory())
            ->setCompanyId(lib_env('ZHICHI_COMPANY_ID'))
            ->setToken($this->getApiToken())
            ->create()
            ->getRobotsCount();

        $this->assertTrue($res->isStatus());
        $data = $res->getData();
        var_dump($data);
        $this->assertEquals(200, $data['code']);
        $this->assertEquals(3, $data['content']);
    }

    // 测试获取外显号码
    public function testNumbers()
    {
        $res = (new ZhichiFactory())
            ->setCompanyId(lib_env('ZHICHI_COMPANY_ID'))
            ->setToken($this->getApiToken())
            ->create()
            ->getNumbers();

        $this->assertTrue($res->isStatus());
        $data = $res->getData();
        var_dump($data);
        $this->assertEquals(200, $data['code']);
    }

    // 测试获取模版
    public function testTemplates()
    {
        $res = (new ZhichiFactory())
            ->setCompanyId(lib_env('ZHICHI_COMPANY_ID'))
            ->setToken($this->getApiToken())
            ->create()
            ->getTemplates();

        $this->assertTrue($res->isStatus());
        $data = $res->getData();
        var_dump($data);
        $this->assertEquals(200, $data['code']);
    }

    // 测试任务创建
    public function testCreateTask()
    {
        $params = [
            'taskName' => '测试任务添加情况2',
            'templateId' => '0c565ba214064f82a7071b25030f78a7',
            'robotNum' => 2,

            // 任务执行时间
            "taskCronList" =>[
                [
                    "begin" => "09:00",
                    "end" => "20:00",
                ]
            ],

            // 重播配置
            'taskRetryList' => [
                [
                    "retryNum" => 1,
                    "retryTime" => 60,
                    "retryCondition" => 3
                ]
            ],

            // 外显号码
            'aniList' => ["01052226451","16512999105"],

            // 任务有效期
            'timeType' => 2,
            'startTime' => (time()+300) * 1000,
            'endTime' => (time()+86400) * 1000,

            // 拨打结果推送
            'pushFlag' => 1,
            'pushType' => 2,
            'pushUrl' => 'https://platform.douyuxingchen.com/api/zhichi/events'
        ];

        $res = (new ZhichiFactory())
            ->setCompanyId(lib_env('ZHICHI_COMPANY_ID'))
            ->setToken($this->getApiToken())
            ->create()
            ->createTask($params);

        $this->assertTrue($res->isStatus());
        $data = $res->getData();
        var_dump($data);
        $this->assertEquals(200, $data['code']);
    }

    private function getApiToken(): string
    {
        $response = (new Http())->setGet()->setUrl(Zhichi::API_URL . 'tokens')
            ->setData([
                'apiKey' => lib_env('ZHICHI_KEY'),
                'apiSecret' => lib_env('ZHICHI_SECRET'),
            ])
            ->request();

        if (!$response->isStatus()) {
            throw new Exception('Failed to get API token');
        }

        $apiRes = $response->getData();

        if (!isset($apiRes['code']) || $apiRes['code'] != Zhichi::API_SUCCESS_CODE) {
            throw new ValidateException('API call failed');
        }

        return $apiRes['content']['accessToken'];
    }

}