<?php
require '../vendor/autoload.php';

$api = new UFS\APISistemas(env('ACESS_TOKEN'), true);
$result = $api->self();
$result = $api->get('departamentos', ['limit' => 10]);
$result = $api->arquivo(env('FILE_ID'), env('FILE_KEY'));

header('Content-Type: application/json');
echo json_encode($result);
