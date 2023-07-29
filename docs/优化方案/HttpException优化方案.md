# HttpException优化方案

当为 Laravel 框架设计 `HttpException` 类时，以下是详细的代码示例：

1. 创建 `HttpException` 类：
    - 在 Laravel 项目中创建一个新的类文件，路径为 `app/Exceptions/HttpException.php`。
    - 在 `HttpException` 类中定义构造函数，接收 `code`、`message` 和 `data` 参数，并将其保存到类的属性中。

```php
<?php

namespace App\Exceptions;

use Exception;

class HttpException extends Exception
{
    protected $code;
    protected $message;
    protected $data;

    public function __construct($code, $message, $data = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;

        parent::__construct($message, $code);
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getData()
    {
        return $this->data;
    }
}
```

2. 在控制器中使用 `HttpException` 类：
    - 导入 `HttpException` 类的命名空间。
    - 在控制器方法中，根据需要创建一个 `HttpException` 实例，并传递相应的 `code`、`message` 和 `data`。
    - 抛出 `HttpException` 实例。

```php
<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpException;

class MyController extends Controller
{
    public function myMethod()
    {
        // 根据需要设置 code、message 和 data
        $code = 404;
        $message = 'Resource not found';
        $data = null;

        throw new HttpException($code, $message, $data);
    }
}
```

3. 自定义异常处理器：
    - 在 Laravel 项目中，可以使用异常处理器来捕获和处理抛出的异常。
    - 打开 `app/Exceptions/Handler.php` 文件。
    - 在 `report` 方法中，可以记录异常到日志或其他处理。
    - 在 `render` 方法中，根据 `HttpException` 类的实例来返回相应的 HTTP 响应。

```php
<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    // ...

    public function render($request, Exception $exception)
    {
        if ($exception instanceof HttpException) {
            $responseData = [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'data' => $exception->getData(),
            ];

            return new JsonResponse($responseData, $exception->getCode());
        }

        return parent::render($request, $exception);
    }
}
```

通过以上代码，你可以为 Laravel 框架设计一个 `HttpException` 类，用于接收代码、消息和数据，并在异常处理器中返回给前端相应的 HTTP 响应。请确保将命名空间、文件路径和方法名与你的项目结构相匹配，并根据实际需求进行调整和扩展。