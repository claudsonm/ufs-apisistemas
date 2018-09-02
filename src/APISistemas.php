<?php

namespace UFS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class APISistemas
{
    const DEV_URL = 'https://apisistemas.desenvolvimento.ufs.br/api/rest/';

    const URL = 'https://apisistemas.ufs.br/api/rest/';

    protected $accessToken;

    protected $httpClient;

    public function __construct(string $accessToken, bool $development = false)
    {
        $this->accessToken = $accessToken;
        $this->httpClient = new Client([
            'base_uri' => ($development ? self::DEV_URL : self::URL),
        ]);
    }

    public function get(string $path)
    {
        try {
            $response = $this->httpClient->request('GET', $path, [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                    'Accept' => 'application/json',
                ],
            ]);
            $content = $response->getBody()->getContents();

            return json_decode($content);
        } catch (GuzzleException $e) {
            var_dump($e);
        }
    }

    public function self()
    {
        $response = $this->get('usuario');

        return $response;
    }
}
