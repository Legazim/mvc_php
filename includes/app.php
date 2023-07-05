<?php

require __DIR__ . "/../vendor/autoload.php";

use \App\Utils\View;
use \WilliamCosta\DatabaseManager\Database;

// Carrega variáveis de ambiente
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


// Define as config do banco de dados
Database::config(
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_PORT']
);

// Define a constante de URL do projeto
define('URL', $_ENV['URL']);

// Define o valor padrão das variaveis
View::init([
    'URL' => URL
]);