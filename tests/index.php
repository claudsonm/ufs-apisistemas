<?php
    require '../vendor/autoload.php';

    $api = new UFS\APISistemas('SEU_ACCESS_TOKEN', true);
    $result = $api->self();

    header('Content-Type: application/json');
    echo json_encode($result);
