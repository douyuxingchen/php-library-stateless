<?php
namespace Douyuxingchen\PhpLibraryStateless\Quest;

use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponseInter;

interface HttpInter {

    /**
     * [可选] GET请求
     *
     * @return HttpInter
     */
    function setGet() : HttpInter;

    /**
     * [可选] POST请求
     *
     * @return HttpInter
     */
    function setPost() : HttpInter;

    /**
     * [必须] 请求URL地址
     *
     * @param string $url
     * @return HttpInter
     */
    function setUrl(string $url) : HttpInter;

    /**
     * [可选] 请求header头
     *
     * @param array $headers
     * @return HttpInter
     */
    function setHeader(array $headers) : HttpInter;

    /**
     * [可选] 设置请求数据
     *
     * @param array $data
     * @return HttpInter
     */
    function setData(array $data): HttpInter;

    /**
     * [可选] 以json方式传输
     *
     * @return HttpInter
     */
    function setJsonData(): HttpInter;

    /**
     * [必须] 发起请求
     *
     * @return ThirdPartyResponseInter
     */
    public function request() : ThirdPartyResponseInter;
}