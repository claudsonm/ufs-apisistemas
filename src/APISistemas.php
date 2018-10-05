<?php

namespace UFS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class APISistemas
{
    const DEV_URL = 'https://apisistemas.desenvolvimento.ufs.br/api/rest/';

    const URL = 'https://apisistemas.ufs.br/api/rest/';

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @var int
     */
    protected $timeout = 0;

    /**
     * Cria uma nova instância da APISistemas.
     *
     * @param string $accessToken
     * @param bool   $development
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
     * @param int    $id
     * @param string $key
     *
     * @return mixed|string
     */
    public function arquivo(int $id, string $key)
    {
        return $this->get('arquivo/'.$id, ['key' => $key]);
    }

    /**
     * Faz a requisição ao caminho informado, podendo utilizar query strings.
     *
     * @param string     $path
     * @param null|array $query
     *
     * @return array|mixed
     */
    public function get(string $path, array $query = null)
    {
        try {
            $options['headers'] = [
                'Authorization' => 'Bearer '.$this->accessToken,
            ];
            if ($this->timeout) {
                $options['timeout'] = $this->timeout;
            }
            if (! empty($query)) {
                $options['query'] = $query;
            }
            $response = $this->httpClient->request('GET', $path, $options);
            $content = $response->getBody()->getContents();

            return json_decode($content);
        } catch (GuzzleException $e) {
            return [
                'errors' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ],
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

    /**
     * Efetua a requisição das Client Credentials da aplicação.
     *
     * @param string      $clientId
     * @param string      $clientSecret
     * @param null|string $state
     *
     * @return array|mixed
     */
    public function getClientCredentials(string $clientId, string $clientSecret, string $state = null)
    {
        try {
            $options['form_params'] = [
                'grant_type' => 'client_credentials',
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'scope' => $state,
            ];
            if ($this->timeout) {
                $options['timeout'] = $this->timeout;
            }
            $response = $this->httpClient->post('token', $options);
            $content = json_decode($response->getBody()->getContents(), true);
            $this->accessToken = $content['access_token'];

            return $content;
        } catch (GuzzleException $e) {
            return [
                'errors' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ],
            ];
        }
    }

    /**
     * Define o tempo de timeout para ser utilizado nos requests.
     *
     * @param int $seconds
     */
    public function setTimeout(int $seconds)
    {
        $this->timeout = $seconds;
    }
}
