<?php
namespace Douyuxingchen\PhpLibraryStateless\Quest;

use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponse;
use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponseInter;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Http implements HttpInter
{
    /**
     * Method
     */
    const GET       =   'GET';
    const POST      =   'POST';
    const PUT       =   'PUT';
    const DELETE    =   'DELETE';
    const HEAD      =   'HEAD';
    const OPTIONS   =   'OPTIONS';
    const PATCH     =   'PATCH';

    private $method = self::GET;
    private $url;
    private $timeout = 5;
    private $headers = [];
    private $dataType;
    private $data;

    function setGet() : HttpInter
    {
        $this->method = self::GET;
        return $this;
    }

    function setPost() : HttpInter
    {
        $this->method = self::POST;
        return $this;
    }

    function setTimeout(int $timeout) : HttpInter
    {
        $this->timeout = $timeout;
        return $this;
    }

    function setUrl(string $url) : HttpInter
    {
        $this->url = $url;
        return $this;
    }

    function setHeader(array $headers) : HttpInter
    {
        $this->headers = $headers;
        return $this;
    }

    function setData(array $data): HttpInter
    {
        $this->data = $data;
        return $this;
    }

    function setJsonData(): HttpInter
    {
        $this->dataType = 'json';
        return $this;
    }

    /**
     * 请求发送
     *
     * @return ThirdPartyResponseInter
     * @throws GuzzleException
     */
    public function request() : ThirdPartyResponseInter
    {
        try {
            $client = new Client([
                'base_uri' => $this->url,
                'timeout'  => $this->timeout,
            ]);

            $options = ['headers' => $this->headers];

            switch ($this->method) {
                case self::GET:
                    $options['query'] = $this->data;
                    break;
                case self::POST:
                    if ($this->dataType === 'json') {
                        $options['json'] = $this->data;
                    } else {
                        $options['form_params'] = $this->data;
                    }
                    break;
            }

            $response = $client->request($this->method, '', $options);
            $code = $response->getStatusCode();
            if($code != 200) {
                return ThirdPartyResponse::create(false, "HttpRequestFailed")->setData([
                    'http_code' => $code,
                    'client' => $client,
                    'response' => $response
                ]);
            }

            return ThirdPartyResponse::create(true, 'HttpRequestSuccess')
                ->setData(json_decode((string)$response->getBody(), true));

        } catch (GuzzleException|Exception $e) {
            return ThirdPartyResponse::create(false, 'HttpRequestException: '. $e->getMessage())->setData([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

}