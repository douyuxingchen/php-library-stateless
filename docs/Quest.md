# HTTP请求封装

## 请求示例

### GET 请求示例
```php
$response = (new Http())->setGet()
     ->setUrl('https://example.com/api')
     ->setHeader(['Authorization' => 'Bearer TOKEN'])
     ->setData(['param1' => 'value1', 'param2' => 'value2'])
     ->request();
```

###  带表单数据的 POST 请求示例
```php
$response = (new Http())->setPost()
     ->setUrl('https://example.com/api')
     ->setHeader(['Authorization' => 'Bearer TOKEN'])
     ->setData(['param1' => 'value1', 'param2' => 'value2'])
     ->request();
```

## 使用 JSON 数据的 POST 请求示例
```php
$response = (new Http())->setPost()
    ->setJsonData()
    ->setUrl('https://example.com/api')
    ->setHeader(['Authorization' => 'Bearer TOKEN'])
    ->setData(['param1' => 'value1', 'param2' => 'value2'])
    ->request();
```