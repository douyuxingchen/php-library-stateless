<?php
namespace Douyuxingchen\PhpLibraryStateless\Exceptions;

use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponse;
use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponseInter;
use Throwable;

class ExceptionHandler {

    /**
     * 全局异常处理方法
     *
     * @param Throwable $exception
     * @return ThirdPartyResponseInter
     */
    public static function handleGlobalException(Throwable $exception) {
        return ThirdPartyResponse::create(false, "library exception")->setData([
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'exception' => $exception,
        ]);
    }

    /**
     * 注册全局异常处理函数
     *
     * @return void
     */
    public static function register() {
        set_exception_handler([__CLASS__, 'handleGlobalException']);
    }
}
