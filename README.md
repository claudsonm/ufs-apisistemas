# UFS APISistemas
Um simples pacote para consumir os serviços disponibilizados pela API da UFS 
(Universidade Federal de Sergipe).

# Instalação
Na pasta do seu projeto, execute o comando `composer require claudsonm/ufs-apisistemas`.

# Exemplo de Utilização

```php
require '../vendor/autoload.php';

$api = new UFS\APISistemas('c7a4669229ca1c730ad125acd337bf49', true);
$result = $api->self();

header('Content-Type: application/json');
echo json_encode($result);
```

