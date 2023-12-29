# 飞鸽发短信

## 调用示例

### 发送普通短信
```php
$smsBuilder = new SmsBuilder();
$sms = $smsBuilder->setMobile('1234567890')
                  ->setSignId(45618)
                  ->setExtNo("666")
                  ->setContent('点击此链接{link}领取{amount}元大礼包')
                  ->setParams(['link1' => 'https://www.baidu.com', 'amount' => '100'])
                  ->build();
$sms->send();
```

### 发送模版短信
```php
$smsBuilder = new SmsBuilder();
$sms = $smsBuilder->setMobile('0987654321')
                    ->setSignId(45618)
                    ->setExtNo("666")
                    ->setTemplateId('template_id_2')
                    ->setContent('大礼包|100|快速到达')
                    ->build();
$sms->sendTemplate();
```