# 短信发送

## 调用示例

## 飞鸽
这里以飞鸽为例展示飞鸽服务商发送不同类型的信息的调用方式

### 发送普通短信
```php
$sms = (new SmsBuilder())->setProvider(new FeigeSmsProvider())
    ->setMobile('1234567890')
    ->setSignId(185283)
    ->setExtNo("666")
    ->setContent('点击此链接{link}领取{amount}元大礼包')
    ->setParams(['link' => 'https://www.baidu.com', 'amount' => '100'])
    ->setSendTime()
    ->build();
$res = $sms->send();
```

### 发送模版短信
```php
$sms = (new SmsBuilder())->setProvider(new FeigeSmsProvider())
    ->setMobile('1234567890')
    ->setSignId(185283)
    ->setExtNo("666")
    ->setTemplateId('143874')
    ->setContent('大礼包|100|快速到达')
    ->setSendTime()
    ->build();
$res = $sms->sendTemplate();
```

## 腾讯

### 发送普通短信
```php

```

## 文档