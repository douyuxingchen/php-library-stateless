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

## 文档  
### 参数生成逻辑
- 调用参数建造者方法，定义具体的建造者类
- 传入指定的参数，以及模版的code
- 最终根据参数和模版code生成具体的参数（注意：这里的生成参数会校验参数和模版字段是否匹配，如果不匹配则会抛出异常）

> 模版code如何获取：
> 可以在数据库 `doubanjiang.sms_templates` 查询
> 该数据表字段设计逻辑是，数据表字段 `key` 是唯一的，`code` 不一定唯一，所以一般需要根据 `key` 找到最终的 `code`