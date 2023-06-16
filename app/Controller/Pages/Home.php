<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Home extends Page
{
    public static function getHome()
    {
        // View da Home
        $content = View::render(
            'pages/home',
            [
                'name' => 'MKAdmin',
                'description' => 'Informatica SDC'
            ]
        );

        // Retorna a view da página
        return parent::getPage("MK Admin", $content);
    }

}

?>