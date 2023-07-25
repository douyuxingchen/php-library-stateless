# 智齿获取Token示例

因为智齿系统对token获取有频率限制，所以建议获取token不要频繁获取，您可以将获取的token保存至redis。  
以下代码为获取的示例代码，可以参数以下代码实现token获取逻辑。

```php
<?php
namespace Xxxx\Xxxx;

use Douyuxingchen\PhpLibraryStateless\Call\Zhichi;
use Douyuxingchen\PhpLibraryStateless\Exceptions\Exception;
use Douyuxingchen\PhpLibraryStateless\Exceptions\ValidateException;
use Douyuxingchen\PhpLibraryStateless\Quest\Http;
use Illuminate\Support\Facades\Cache;

class XxxService

    const CACHE_KEY = 'zhichi:token';
    const CACHE_EXP = 86400 - 60*5;

    public function getToken(bool $refresh = false) : string {
        if ($refresh) {
            Cache::store('redis')->forget(self::CACHE_KEY);
        }

        return Cache::store('redis')->remember(self::CACHE_KEY, self::CACHE_EXP, function () {
            $response = (new Http())->setGet()->setUrl(Zhichi::API_URL . 'tokens')
                ->setData([
                    'apiKey' => env('ZHICHI_KEY'),
                    'apiSecret' => env('ZHICHI_SECRET'),
                ])
                ->request();

            if (!$response->isStatus()) {
                throw new Exception('Failed to get API token');
            }

            $apiRes = $response->getData();

            if (!isset($apiRes['code']) || $apiRes['code'] != Zhichi::API_SUCCESS_CODE) {
                throw new Exception('API call failed');
            }

            return $apiRes['content']['accessToken'];
        });
    }
}
```