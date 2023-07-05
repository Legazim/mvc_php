<?php

use \App\Http\Response;
use \App\Controller\Pages;

// Rota da home
$obRouter->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

// Rota sobre
$obRouter->get(
    '/about',
    [
        function () {
            return new Response(200, Pages\About::getAbout());
        }
    ]
);

// Rota dinamica
$obRouter->get('/depoimentos', [
    function () {
        return new Response(200, Pages\Testimony::getTestimonies());
    }
]);

// Rota dinamica
$obRouter->post('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\Testimony::insertTestmony($request));
    }
]);