<?php
namespace Douyuxingchen\PhpLibraryStateless\Exceptions;

/**
 * 自定义Http接口响应
 * @deprecated 保留的Exception 暂时不启用
 */
class HttpException extends Exception {

    protected $code;
    protected $message;
    protected $data;

    public function __construct($code, $message = null, $data = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;

        parent::__construct($message, $code);
    }

    public function getData()
    {
        return $this->data;
    }

}