<?php

namespace Surender\ProdegeApi\Responses;

class ResponseHandler
{
    protected array $raw;
    protected array $returnStatus;

    public function __construct(array $response)
    {
        $this->raw = $response;
        $this->returnStatus = $this->raw['return_status'] ?? [];
    }

    public function index()
    {
        return $this->raw;
    }

    public function isSuccess(): bool
    {
        return ($this->returnStatus['status_id'] ?? 0) === 1;
    }

    public function getMessage(): string
    {
        return $this->returnStatus['message'][0] ?? 'Unknown message';
    }

    public function getErrorCodes(): array
    {
        return $this->returnStatus['error_codes'] ?? [];
    }

    public function toArray(): array
    {
        return $this->raw;
    }
}
