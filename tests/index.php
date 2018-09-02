<?php
    require '../vendor/autoload.php';

    $api = new UFS\APISistemas('c7a4669229ca1c730ad125acd337bf49', true);
    $result = $api->self();

    header('Content-Type: application/json');
    echo json_encode($result);
