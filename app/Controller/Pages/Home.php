<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Home extends Page
{
    public static function getHome()
    {
        $obOrganization = new Organization;

        // View da Home
        $content = View::render(
            'pages/home',
            [
                'name' => $obOrganization->name,
            ]
        );

        // Retorna a view da página
        return parent::getPage("MK Admin - HOME", $content);
    }

}

?>