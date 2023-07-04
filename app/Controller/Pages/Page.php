<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Page
{

    /**
     * Renderizar o topo da página
     * @return string
     */
    private static function getHeader()
    {
        return View::render('pages/header');

    }

    /**
     * Renderizar o final da página
     * @return string
     */
    private static function getFooter()
    {
        return View::render('pages/footer');

    }

    /**
     * Retorna o conteudo de nossa pagina generica
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render(
            'pages/page',
            [
                'title' => $title,
                'header' => self::getHeader(),
                'footer' => self::getFooter(),
                'content' => $content
            ]
        );
    }
}

?>