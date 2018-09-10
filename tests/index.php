<?php
require '../vendor/autoload.php';

// Inicialização sem um Access Token. Útil para usar com Client Credentials
$api = new \UFS\APISistemas(null, true);
// Obtenção das client credentials
$result = $api->getClientCredentials(env('UFS_KEY'), env('UFS_SECRET'));
// Realização de uma requisição ao endpoint solicitado com um query parameter
$result = $api->get('departamentos', ['limit' => 200]);

// Inicialização com um Access Token do usuário (Authorization Code)
//$api = new \UFS\APISistemas(env('ACESS_TOKEN'), true);
// Obtendo os dados do usuário logado
//$result = $api->self();
// Realização de uma requisição a um arquivo
//$result = $api->arquivo(env('FILE_ID'), env('FILE_KEY'));

header('Content-Type: application/json');
echo json_encode($result);
