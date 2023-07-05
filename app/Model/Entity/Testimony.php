<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Testimony
{
    public int $id;

    public string $nome;

    public string $mensagem;

    public string $data;

    public function cadastrar()
    {
        // DEFINE A DATA
        $this->data = date('Y-m-d H:i:s');

        // Insere o depoimento no banco de dados
        $this->id = (new Database('depoimentos'))->insert([
            'nome' => $this->nome,
            'mensagem' => $this->mensagem,
            'data' => $this->data
        ]);

        return true;
    }


    public static function getTestimonies(
        string|null $where = null,
        string|null $order = null,
        string|null $limit = null,
        \PDOStatement|string $fields = '*'
    ) {
        return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
    }
}