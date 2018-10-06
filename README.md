# UFS APISistemas
[![Latest Version](https://badgen.net/github/release/claudsonm/ufs-apisistemas)](https://github.com/claudsonm/ufs-apisistemas/releases)
[![Total Downloads](https://poser.pugx.org/claudsonm/ufs-apisistemas/downloads)](https://packagist.org/packages/claudsonm/ufs-apisistemas)
[![License](https://poser.pugx.org/claudsonm/ufs-apisistemas/license)](https://packagist.org/packages/claudsonm/ufs-apisistemas)

Um simples pacote para consumir os serviços disponibilizados pela API da UFS 
(Universidade Federal de Sergipe).

# Instalação
Na pasta do seu projeto, execute o comando `composer require claudsonm/ufs-apisistemas`.

# Exemplo de Utilização

```php

require 'vendor/autoload.php';

// Obtenção das client credentials para consumir serviços públicos
$credentials = \UFS\APISistemas::getClientCredentials(
    env('UFS_KEY'),
    env('UFS_SECRET'),
    null,
    true
);

// Inicialização com o Access Token obtido
$api = new \UFS\APISistemas($credentials['access_token'], true);

// Realização de uma requisição ao endpoint solicitado com um query parameter
$result = $api->get('departamentos', ['limit' => 10]);

// Altera o tipo de retorno para um objetivo ao invés de um array associativo
$result = $api->get('departamentos', ['limit' => 10, 'assoc_decode' => false]);

/**
 * MÉTODOS DISPONÍVEIS
 * Para acessar endpoints privados será necessário utilizar a classe com um
 * access_token de usuário.
 */

// Obtendo os dados do usuário logado
$result = $api->self();

// Realização de uma requisição a um arquivo
$result = $api->arquivo(env('FILE_ID'), env('FILE_KEY'));

header('Content-Type: application/json');
echo json_encode($credentials + $result);
```

