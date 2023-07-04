<?php

namespace App\Http;

class Response
{
    private int $httpCode = 200;
    private array $headers;
    private string $contentType = 'text/html';
    private mixed $content;

    /**
     * Iniciar classes e definir valores
     * @param  int $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * Alterar content type do response
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Adiciona registro no cabeçalho de response
     * @param string $key
     * @param string $value
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Envia headers para o navegador
     */
    private function sendHeaders()
    {
        // Status
        http_response_code($this->httpCode);

        // Enviar headers
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
    }

    /**
     * Enviar resposta para o usuario
     */
    public function sendResponse()
    {
        // Enviar header
        $this->sendHeaders();

        // Envia o conteudo
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }

}