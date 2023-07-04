<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Testimony extends Page
{
    /**
     * Retorna o conteudo da view de depoimentos
     */
    public static function getTestimonies()
    {
        $obOrganization = new Organization;

        $content = View::render('pages/testimonies', [
            'name' => 'Testimonies'
        ]);

        return parent::getPage('Depoimentos > MKDEVEL', $content);
    }
}