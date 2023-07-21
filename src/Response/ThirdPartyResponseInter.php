<?php
namespace Douyuxingchen\PhpLibraryStateless\Response;

/**
 * 第三方接口统一响应封装
 *
 * 1. 封装第三方响应：可以将第三方的响应数据进行封装，统一处理和管理。这样可以提高代码的可维护性和可读性，减少重复的代码逻辑。
 * 2. 统一的数据结构：该接口定义了一组标准的方法和数据结构，可以确保第三方响应数据在不同的场景下具有一致的格式和类型。这样可以简化 Service 层的处理逻辑，减少错误和异常情况的处理。
 * 3. 提供可靠的错误处理：接口中的方法可以提供对错误情况的处理和判断。例如，通过 isStatus() 方法可以判断响应的状态是成功还是失败，通过 getMessage() 方法可以获取与响应关联的消息，从而更好地处理错误和异常情况。
 * 4. 可扩展性和灵活性：通过使用接口，可以在不改变 Service 层代码的情况下，轻松切换和适应不同的第三方服务。如果需要更换第三方服务提供商或者对接新的接口，只需要实现 ThirdPartyResponseInter 接口即可，而无需修改 Service 层的代码。
 */
interface ThirdPartyResponseInter {

    /**
     * 创建 ThirdPartyResponse 的新实例。
     *
     * @param bool $status 响应的状态。
     * @param string|null $message 响应的消息（可选）。
     * @return ThirdPartyResponseInter 创建的 ThirdPartyResponse 实例。
     */
    public static function create(bool $status, ?string $message = null): ThirdPartyResponseInter;

    /**
     * 获取响应的状态。
     *
     * @return bool 响应的状态。
     */
    public function isStatus(): bool;

    /**
     * 设置与响应关联的code。
     *
     * @param int $code code
     * @return ThirdPartyResponseInter
     */
    public function setCode(int $code): ThirdPartyResponseInter;

    /**
     * 设置与响应关联的时间（单位：毫秒）。
     *
     * @param int $duration 响应时间
     * @return ThirdPartyResponseInter
     */
    public function setDuration(int $duration): ThirdPartyResponseInter;

    /**
     * 设置与响应关联的消息。
     *
     * @param string $message 要设置的消息。
     * @return ThirdPartyResponseInter 更新后的 ThirdPartyResponse 实例。
     */
    public function setMessage(string $message): ThirdPartyResponseInter;

    /**
     * 设置与响应关联的请求 ID。
     *
     * @param string $requestId 要设置的请求 ID。
     * @return ThirdPartyResponseInter 更新后的 ThirdPartyResponse 实例。
     */
    public function setRequestId(string $requestId): ThirdPartyResponseInter;

    /**
     * 设置与响应关联的数据。
     *
     * @param array|null $data 要设置的数据（可选）。
     * @return ThirdPartyResponseInter 更新后的 ThirdPartyResponse 实例。
     */
    public function setData(?array $data = []): ThirdPartyResponseInter;

    /**
     * 获取响应code。
     *
     * @return int
     */
    public function getCode(): int;

    /**
     * 获取与响应关联的时间（单位：毫秒）。
     *
     * @return int
     */
    public function getDuration(): int;

    /**
     * 获取与响应关联的消息。
     *
     * @return array|null 响应关联的数据，如果未设置则为 null。
     */
    public function getMessage(): ?string;

    /**
     * 获取与响应关联的请求 ID。
     *
     * @return string|null 响应关联的请求 ID，如果未设置则为 null。
     */
    public function getRequestId(): ?string;

    /**
     * 获取与响应关联的数据。
     *
     * @return array|null 响应关联的数据，如果未设置则为 null。
     */
    public function getData(): ?array;

    /**
     * 将响应转换为数组。
     *
     * @return array 响应的数组表示。
     */
    public function toArray(): array;

    /**
     * 将响应转换为 JSON 字符串。
     *
     * @return string 响应的 JSON 字符串表示。
     */
    public function toJson(): string;

}
