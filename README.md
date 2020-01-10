# Zenvia SMS

 Este pacote integra a API do Zenvia SMS Gateway 2.0 ao seu aplicativo PHP
 
## Principais recursos

* [x] Envio de SMS.
* [x] Envio de Multiplos SMSs.
* [x] Agendamento de Envio de SMS.

## Dependências

* PHP >= 5.6 

## Instalação

Se já possui um arquivo `composer.json`, basta adicionar a seguinte dependência ao seu projeto:

```json
"require": {
    "reatos/zenvia": ">=1.0"
}
```

Com a dependência adicionada ao `composer.json`, basta executar:

```
composer install
```

Alternativamente, você pode executar diretamente em seu terminal:

```
composer require reatos/zenvia
```

## Utilizando

Para enviar somente um SMS, basta fazer:

### Enviando SMS

```php
<?php 

require __DIR__.'/vendor/autoload.php';
use Zenvia\Request as Zenvia;

$Zenvia = new Zenvia('Login', 'Senha');

$response = $Zenvia->sendSMS('55319999999999', 'Testando SMS'/*, '2014-08-22T14:55:00' // Campo Opcional para agendar envio */);

print_r($response);

// ...
```

### Enviando Multiplos SMSs

```php
<?php 

require __DIR__.'/vendor/autoload.php';
use Zenvia\Request as Zenvia;

$Zenvia = new Zenvia('Login', 'Senha');

$messages = [
    [
     // 'schedule' => '2014-08-22T14:55:00', // Campo Opcional para agendar envio
        'to' => '55319999999999',
        'msg' => 'Testando SMS'
    ],
    [
     // 'schedule' => '2014-08-22T14:55:00', // Campo Opcional para agendar envio
        'to' => '55319999999999',        
        'msg' => 'message 2'
    ],
];

$response = $Zenvia->sendSMSMultipe($messages);

print_r($response);

// ...
```
 
## Documentação Oficial

A documentação para o SMS Zenvia pode ser encontrada em [Zenvia Documentação](https://zenviasms.docs.apiary.io/)
 
 ## License
 
Este projeto é de código aberto e licenciado sob a [MIT license.](https://opensource.org/licenses/MIT)
