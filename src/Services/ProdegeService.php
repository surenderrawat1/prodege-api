<?php

namespace Surender\ProdegeApi\Services;

use GuzzleHttp\Client;
use Surender\ProdegeApi\Contracts\ProdegeApiInterface;
use Surender\ProdegeApi\Responses\ResponseHandler;

class ProdegeService implements ProdegeApiInterface
{
    protected string $baseUrl;
    protected Client $http;

    public function __construct()
    {
        $this->baseUrl = config('prodege.base_url');
        $this->http = new Client();
    }

    public function generateSignedParams(array $data): array
    {
        $data['apik'] = config('prodege.api_key');
        $data['secret_key'] = config('prodege.secret');
        $data['request_date'] = TimeHelper::getRequestDate();
        $data['signature'] = SignatureBuilder::generate($data);

        //unset($data['secret_key']); // 🚫 Never send the secret key in requests

        return $data;
    }

    public function generateSignedUrl(string $endpoint, array $params): string
    {
        $signed = $this->generateSignedParams($params);
        return rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/') . '?' . http_build_query($signed);
    }

    public function get(string $endpoint, array $params = [])
    {
        $url = $this->generateSignedUrl($endpoint, $params);
        $response = $this->http->get($url);
        return new ResponseHandler(json_decode($response->getBody()->getContents(), true));
    }

    public function post(string $endpoint, array $params = [])
    {
        $signed_payload = $this->generateSignedParams($params);
        //dd(rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/'), $signed_payload);
        $response = $this->http->post(rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/'), [
            'form_params' => $signed_payload
        ]);
        return new ResponseHandler(json_decode($response->getBody()->getContents(), true));
    }
}
