<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Page
{
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
                'content' => $content
            ]
        );
    }
}

?>