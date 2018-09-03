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

    /**
     * Cria uma nova instância da APISistemas.
     *
     * @param  string  $accessToken
     * @param  bool  $development
     */
    public function __construct(string $accessToken, bool $development = false)
    {
        $this->accessToken = $accessToken;
        $this->httpClient = new Client([
            'base_uri' => ($development ? self::DEV_URL : self::URL),
        ]);
    }

    /**
     * Faz a requisição ao caminho informado, podendo utilizar query strings.
     *
     * @param  string  $path
     * @param  array|null  $query
     * @return mixed|string
     */
    public function get(string $path, array $query = null)
    {
        try {
            $options['headers'] = [
                'Authorization' => 'Bearer '.$this->accessToken,
                'Accept' => 'application/json',
            ];
            if (! empty($query)) {
                $options['query'] = $query;
            }
            $response = $this->httpClient->request('GET', $path, $options);
            $content = $response->getBody()->getContents();

            return json_decode($content);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Realiza uma requisição ao endpoint que retorna os dados do usuário.
     *
     * @return mixed|string
     */
    public function self()
    {
        $response = $this->get('usuario');

        return $response;
    }
}
