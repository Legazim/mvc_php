<?php

namespace App\Utils;

class View
{

    private static array $vars;

    /**
     * Define os dados iniciais da classe
     */
    public static function init($vars = [])
    {
        self::$vars = $vars;
    }

    /**
     * Retorna o conteudo de uma view
     * @param string $view
     * @return string
     */
    private static function getContentView($view): string
    {
        $file = __DIR__ . "/../../resources/view/$view.html";
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * Retorna o conteudo renderizado de uma view
     * @param string $view
     * @param array $vars (string/numeric)
     * @return string
     */
    public static function render($view, $vars = [])
    {
        // Conteudo da view
        $contentView = self::getContentView($view);

        // Merge de variaveis do layout
        $vars = array_merge(self::$vars, $vars);

        // Chaves dos arrays
        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);

        return str_replace($keys, array_values($vars), $contentView);
    }

}

?>