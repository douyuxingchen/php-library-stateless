# 短信参数生成
根据不同的短信服务商，不同的模版ID生成不同的短信模版参数

## 示例
### 飞鸽
这里以飞鸽为例展示参数生成的过程
```php
$res = (new ParamsBuilder())->setProvider(new FeigeParamsGen())
    ->setParams(['link' => 'https://www.baidu.com'])
    ->setTempCode(FeigeParamsGen::CODE_YUN_CREATE_ORDER)
    ->build()
    ->genParams();
```
