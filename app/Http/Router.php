<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;

class Router
{

    // URL completa do projeto (raiz)
    private string $url = '';

    // Prefixo de todas as rotas
    private string $prefix;

    // Indice de rotas
    private array $routes;

    // Instancia de request
    private Request $request;

    public function __construct($url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * Define o prefixo das rotas
     */
    private function setPrefix(): void
    {
        // Informações da URL
        $parseUrl = parse_url($this->url);

        // Define o prefixo
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Adiciona uma rota na classe
     */
    private function addRoute($method, $route, $params)
    {
        // Validação dos parametros
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        // Variaveis da rota
        $params['variables'] = [];

        // Padrao de validação das variaveis das rotas
        $patternVariable = '/{(.*?)}/';
        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];

        }


        // Padrão de validação da URL
        $patterRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        // Adiciona a rota dentro da classe
        $this->routes[$patterRoute][$method] = $params;
    }

    /**
     * Define uma rota de GET
     */
    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    /**
     * Define uma rota de POST
     */
    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * Define uma rota de PUT
     */
    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    /**
     * Define uma rota de DELETE
     */
    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }


    /**
     * Retorna a URI deconsiderando o prefixo;
     */
    private function getUri(): string
    {
        $uri = $this->request->getUri();

        // Fatia a URI com o prefixo
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        // returna a URI sem prefixo
        return end($xUri);
    }

    /**
     * Retorna os dados da rota atual
     */
    private function getRoute(): array
    {
        // URI
        $uri = $this->getUri();

        // Method
        $httpMethod = $this->request->getHttpMethod();

        // Valida as URLs (rotas)
        foreach ($this->routes as $patternRoutes => $methods) {
            // Verifica se a URI é igual ao padrão
            if (preg_match($patternRoutes, $uri, $matches)) {
                // Verifica o metodo
                if (isset($methods[$httpMethod])) {
                    // Remover a primeira posição
                    unset($matches[0]);

                    // Variaveis processadas
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    // Retorno dos parametros da rota
                    return $methods[$httpMethod];
                }

                // Metodo não definido/permitido
                throw new Exception("Método não permitido", 405);
            }
        }

        // URL não encontrada
        throw new Exception("URL não encontrada", 404);
    }

    /**
     * Metodo responsavel por executar a rota atual
     */
    public function run(): Response
    {
        try {
            // Obtem a rota atual
            $route = $this->getRoute();

            // Verifica o controlador
            if (!isset($route['controller'])) {
                throw new Exception("A URL não pode ser processada", 500);
            }

            // Argumentos da execução
            $args = [];

            // Reflection
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            // Retorna a execução da função
            return call_user_func_array($route['controller'], $args);

        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}