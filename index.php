<?php

require __DIR__ . '/includes/app.php';

use App\Http\Router;

// Inicia o router
$obRouter = new Router(URL);

// Inclui a rota de paginas
include __DIR__ . '/routes/pages.php';

// Imprime o Response
$obRouter->run()
    ->sendResponse();