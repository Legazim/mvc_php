<?php

namespace App\Controller\Pages;

use App\Http\Request;
use \App\Utils\View;
use \App\Model\Entity\Testimony as EntityTestimony;

class Testimony extends Page
{
    /**
     * Obtem a renderização dos itens de depoimentos para a pagina
     */
    private static function getTestimonyItens()
    {
        // depoimentos
        $itens = '';

        $results = EntityTestimony::getTestimonies(null, 'id DESC');

        // renderiza o item
        while ($obTestimonies = $results->fetchObject(EntityTestimony::class)) {
            $itens .= View::render('pages/testimony/item', [
                'nome' => $obTestimonies->nome,
                'mensagem' => $obTestimonies->mensagem,
                'data' => date('d/m/Y H:i:s', strtotime($obTestimonies->data))
            ]);
        }

        return $itens;
    }

    /**
     * Retorna o conteudo da view de depoimentos
     */
    public static function getTestimonies(): string
    {
        // View de depoimentos
        $content = View::render('pages/testimonies', [
            'itens' => self::getTestimonyItens()
        ]);

        return parent::getPage('Depoimentos > MKDEVEL', $content);
    }

    /**
     * Cadastra um depoimento
     */
    public static function insertTestmony(Request $request): string
    {
        $postVars = $request->getPostVars();

        // Nova instancia de depoimento
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();

        return self::getTestimonies();
    }
}