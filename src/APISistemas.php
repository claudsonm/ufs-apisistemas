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
    public function __construct(string $accessToken = null, bool $development = false)
    {
        $this->accessToken = $accessToken;
        $this->httpClient = new Client([
            'base_uri' => ($development ? self::DEV_URL : self::URL),
        ]);
    }

    /**
     * Retorna um arquivo da APISistemas.
     *
     * @param  int  $id
     * @param  string  $key
     * @return mixed|string
     */
    public function arquivo(int $id, string $key)
    {
        return $this->get('arquivo/'.$id, ['key' => $key]);
    }

    /**
     * Faz a requisição ao caminho informado, podendo utilizar query strings.
     *
     * @param  string  $path
     * @param  array|null  $query
     * @return array|mixed
     */
    public function get(string $path, array $query = null)
    {
        try {
            $options['headers'] = [
                'Authorization' => 'Bearer '.$this->accessToken,
            ];
            if (! empty($query)) {
                $options['query'] = $query;
            }
            $response = $this->httpClient->request('GET', $path, $options);
            $content = $response->getBody()->getContents();

            return json_decode($content);
        } catch (GuzzleException $e) {
            return [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Realiza uma requisição ao endpoint que retorna os dados do usuário.
     *
     * @return mixed|string
     */
    public function self()
    {
        return $this->get('usuario');
    }

    public function getClientCredentials(string $clientId, string $clientSecret, string $state = null)
    {
        $response = $this->httpClient->post('token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'scope' => $state,
            ],
        ]);
        $content = json_decode($response->getBody()->getContents());
        $this->accessToken = $content->access_token;

        return $content;
    }
}
