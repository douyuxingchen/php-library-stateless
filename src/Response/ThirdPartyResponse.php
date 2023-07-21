<?php
namespace Douyuxingchen\PhpLibraryStateless\Response;

class ThirdPartyResponse implements ThirdPartyResponseInter {

    private $status;
    private $code;
    private $duration;
    private $message;
    private $requestId;
    private $data;

    public function __construct(bool $status, ?string $message = null) {
        $this->status = $status;
        $this->message = $message;
    }

    public static function create(bool $status, ?string $message = null): ThirdPartyResponseInter {
        return new self($status, $message);
    }

    public function isStatus(): bool {
        return $this->status;
    }

    public function setCode(int $code): ThirdPartyResponseInter
    {
        $this->code = $code;
        return $this;
    }

    public function setDuration(int $duration): ThirdPartyResponseInter
    {
        $this->duration = $duration;
        return $this;
    }

    public function setMessage(string $message): ThirdPartyResponseInter
    {
        $this->message = $message;
        return $this;
    }

    public function setRequestId(string $requestId): ThirdPartyResponseInter
    {
        $this->requestId = $requestId;
        return $this;
    }

    public function setData(?array $data = []): ThirdPartyResponseInter
    {
        $this->data = $data;
        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getMessage(): ?string {
        return $this->message;
    }

    public function getRequestId(): ?string {
        return $this->requestId;
    }

    public function getData(): ?array {
        return $this->data;
    }

    public function toArray(): array {
        return [
            'status' => $this->status,
            'code' => $this->code,
            'duration' => $this->duration,
            'message' => $this->message,
            'request_id' => $this->requestId,
            'data' => $this->data,
        ];
    }

    public function toJson(): string {
        return json_encode($this->toArray(), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }
}
