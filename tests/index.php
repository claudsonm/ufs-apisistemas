<?php

require '../vendor/autoload.php';

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
