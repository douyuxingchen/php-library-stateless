# 外呼系统
## 智齿外呼系统
- 开发文档：http://codecenter.sobot.com/pages/a7053e
- [智齿token获取代码示例](zhichi_get_token_demo.md)

### 调用示例
获取机器人数量
```php
(new ZhichiFactory())->setToken('xxxxxx')->create()->getRobotsCount();
```

查询外呼号码资源
```php
(new ZhichiFactory())->create()->setToken('xxxxxx')->getNumbers();
```

创建任务
```php
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
    ->setToken('xxxxxx')
    ->create()
    ->createTask($params);
```