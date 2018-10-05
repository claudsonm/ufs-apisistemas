<?php

namespace UFS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class APISistemas
{
    /**
     * URI base do ambiente de desenvolvimento da APISistemas.
     */
    const DEV_URL = 'https://apisistemas.desenvolvimento.ufs.br/api/rest/';

    /**
     * URI base do ambiente de produção da APISistemas.
     */
    const URL = 'https://www.sistemas.ufs.br/api/rest/';

    /**
     * Access token utilizado para fazer as requisições.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * Cliente HTTP para realizar as requisições.
     *
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * Define o tempo de timeout das requisições.
     *
     * @var int
     */
    protected $timeout = 0;

    /**
     * Cria uma nova instância da APISistemas.
     *
     * @param string $accessToken
     * @param bool   $development
     */
    public function __construct(string $accessToken, bool $development = false)
    {
        $this->accessToken = $accessToken;
        $this->httpClient = self::makeHttpClient($development);
    }

    /**
     * Retorna um arquivo da APISistemas.
     *
     * @param int    $id
     * @param string $key
     *
     * @return array
     */
    public function arquivo(int $id, string $key)
    {
        return $this->get('arquivo/'.$id, ['key' => $key]);
    }

    /**
     * Faz a requisição ao endpoint informado, podendo utilizar query strings.
     *
     * @param string     $path
     * @param array|null $query
     *
     * @return array
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

            return json_decode($content, true);
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
     * Efetua a requisição das Client Credentials da aplicação.
     *
     * @param string      $clientId
     * @param string      $clientSecret
     * @param string|null $state
     * @param bool        $development
     *
     * @return array
     */
    public static function getClientCredentials(
        string $clientId,
        string $clientSecret,
        string $state = null,
        bool $development = false
    ) {
        try {
            $options['form_params'] = [
                'grant_type' => 'client_credentials',
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'scope' => $state,
            ];
            $httpClient = self::makeHttpClient($development);
            $response = $httpClient->post('token', $options);
            $content = $response->getBody()->getContents();

            return json_decode($content, true);
        } catch (ClientException $e) {
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
     * @return array
     */
    public function self()
    {
        return $this->get('usuario');
    }

    /**
     * Altera o access token utilizado pela classe.
     *
     * @param string $token
     */
    public function setAccessToken(string $token)
    {
        $this->accessToken = $token;
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

    /**
     * Cria o cliente HTTP para ser utilizado nas requisições.
     *
     * @param bool $development
     *
     * @return \GuzzleHttp\Client
     */
    private static function makeHttpClient(bool $development)
    {
        return new Client(['base_uri' => ($development ? self::DEV_URL : self::URL)]);
    }
}
