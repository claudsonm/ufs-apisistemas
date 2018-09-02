# UFS APISistemas
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

