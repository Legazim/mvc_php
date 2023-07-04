<?php

require __DIR__ . "/vendor/autoload.php";

use App\Http\Router;
use App\Utils\View;

// Carrega variáveis de ambiente
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Define a constante de URL do projeto
define('URL', $_ENV['URL']);

// Define o valor padrão das variaveis
View::init([
    'URL' => URL
]);

// Inicia o router
$obRouter = new Router(URL);

// Inclui a rota de paginas
include __DIR__ . '/routes/pages.php';

// Imprime o Response
$obRouter->run()
    ->sendResponse();