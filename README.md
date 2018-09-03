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

$api = new \UFS\APISistemas(env('ACESS_TOKEN'), true);
$result = $api->self();
$result = $api->get('departamentos', ['limit' => 10]);
$result = $api->arquivo(env('FILE_ID'), env('FILE_KEY'));
// Fique atento, novos métodos estão sendo criados.

header('Content-Type: application/json');
echo json_encode($result);
```

