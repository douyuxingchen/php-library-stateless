<?php
namespace Douyuxingchen\PhpLibraryStateless\Call;

use Douyuxingchen\PhpLibraryStateless\Exceptions\Exception;
use Douyuxingchen\PhpLibraryStateless\Exceptions\ValidateException;
use Douyuxingchen\PhpLibraryStateless\Quest\Http;
use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponse;
use Douyuxingchen\PhpLibraryStateless\Response\ThirdPartyResponseInter;

class Zhichi
{
    private $apiToken;
    private $companyId;
    private $http;

    const API_URL = 'https://gw.soboten.com/api/6.0.0/';
    const API_SUCCESS_CODE = 200;

    public function __construct(string $apiToken, string $companyId, Http $http)
    {
        $this->apiToken = $apiToken;
        $this->companyId = $companyId;
        $this->http = $http;
    }

    /**
     * 创建任务
     *
     * @param array $params
     * @return ThirdPartyResponseInter
     * @throws \Exception
     */
    public function createTask(array $params = []): ThirdPartyResponseInter
    {
        $url = 'companies/' . $this->companyId . '/tasks';
        return $this->quest($url, Http::POST, array_merge([
            'companyId' => $this->companyId
        ], $params));
    }

    /**
     * 添加拨打数据
     *
     * @param $taskId
     * @param $data
     * @return ThirdPartyResponseInter
     * @throws \Exception
     */
    public function taskAddContact($taskId, $data): ThirdPartyResponseInter
    {
        $url = 'companies/' . $this->companyId . '/tasks/' . $taskId . '/task-contacts';

        return $this->quest($url, Http::POST, [
            'contactList' => $data,
            'taskId' => $taskId,
        ]);
    }

    /**
     * 查询拨打数据详情
     *
     * @param $taskId
     * @param $outId
     * @return ThirdPartyResponseInter
     * @throws \Exception
     */
    public function getReferenceTaskContacts($taskId, $outId): ThirdPartyResponseInter
    {
        $url = "companies/{$this->companyId}/tasks/{$taskId}/reference-task-contacts/{$outId}";

        return $this->quest($url, Http::GET, [
            'companyId' => $this->companyId,
            'taskId' => $taskId,
            'outId' => $outId,
        ]);
    }

    /**
     * 获取机器人数量
     *
     * @return ThirdPartyResponseInter
     * @throws \Exception
     */
    public function getRobotsCount(): ThirdPartyResponseInter
    {
        $url = "companies/{$this->companyId}/robots/count";

        return $this->quest($url, Http::GET, [
            'companyId' => $this->companyId,
        ]);
    }

    /**
     * 获取任务详情
     *
     * @param $taskId
     * @return ThirdPartyResponseInter
     * @throws \Exception
     */
    public function getTasksInfo($taskId): ThirdPartyResponseInter
    {
        $url = "companies/{$this->companyId}/tasks/{$taskId}";

        return $this->quest($url, Http::GET, [
            'companyId' => $this->companyId,
            'taskId' => $taskId,
        ]);
    }

    /**
     * 获取任务列表
     *
     * @param $params
     * @return ThirdPartyResponseInter
     * @throws \Exception
     */
    public function getTasksList($params = []): ThirdPartyResponseInter
    {
        $url= "companies/{$this->companyId}/searchtasks";
        $params = array_merge($params, [
            'companyId' => $this->companyId,
        ]);

        return $this->quest($url, Http::GET, $params);
    }

    /**
     * 查询模版
     *
     * @return ThirdPartyResponseInter
     * @throws \Exception
     */
    public function getTemplates(): ThirdPartyResponseInter
    {
        $url = "companies/{$this->companyId}/templates";
        return $this->quest($url, Http::GET);
    }

    /**
     * 查询外呼号码资源
     *
     * @return ThirdPartyResponseInter
     * @throws \Exception
     */
    public function getNumbers(): ThirdPartyResponseInter
    {
        $url = "companies/{$this->companyId}/numbers";
        return $this->quest($url, Http::GET);
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $params
     * @return ThirdPartyResponseInter
     * @throws Exception
     * @throws ValidateException
     */
    private function quest(string $url, string $method, array $params = []): ThirdPartyResponseInter
    {
        if (!$this->apiToken) {
            throw new ValidateException('API token is empty');
        }

        $url = self::API_URL . $url;

        if ($method == Http::POST) {
            $this->http->setPost();
        } else {
            $this->http->setGet();
        }

        $response = $this->http->setUrl($url)
            ->setHeader(['Authorization' => 'Bearer ' . $this->apiToken])
            ->setData($params)
            ->setJsonData()
            ->request();

        if (!$response->isStatus()) {
            throw new Exception('API request failed');
        }

        $apiRes = $response->getData();

        if (!isset($apiRes['code']) || $apiRes['code'] != self::API_SUCCESS_CODE) {
            return ThirdPartyResponse::create(false, 'API call failed')->setData($apiRes ?? []);
        }

        return ThirdPartyResponse::create(true, 'success')->setData($apiRes ?? []);
    }
}
