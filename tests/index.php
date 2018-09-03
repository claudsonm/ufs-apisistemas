<?php
require '../vendor/autoload.php';

$api = new UFS\APISistemas(env('ACESS_TOKEN'), true);
$result = $api->self();
$result = $api->get('departamentos', ['limit' => 10]);

header('Content-Type: application/json');
echo json_encode($result);
