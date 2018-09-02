# UFS APISistemas

[![GitHub release](https://img.shields.io/github/release/qubyte/rubidium.svg?style=flat-square)](https://github.com/claudsonm/ufs-apisistemas/releases)
[![Packagist](https://img.shields.io/packagist/dt/doctrine/orm.svg?style=flat-square)](https://packagist.org/packages/claudsonm/ufs-apisistemas)
[![GitHub](https://img.shields.io/github/license/mashape/apistatus.svg?style=flat-square)](MIT)


Um simples pacote para consumir os serviços disponibilizados pela API da UFS 
(Universidade Federal de Sergipe).

# Instalação
Na pasta do seu projeto, execute o comando `composer require claudsonm/ufs-apisistemas`.

# Exemplo de Utilização

```php
require 'vendor/autoload.php';

$api = new UFS\APISistemas('SEU_ACCESS_TOKEN', true);
$result = $api->self();
// Fique atento, novos métodos estão sendo criados.

header('Content-Type: application/json');
echo json_encode($result);
```

