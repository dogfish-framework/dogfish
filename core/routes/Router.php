<?php

namespace DogfishCore\routes;

use Exception;
use DogfishCore\http\Response;

class Router
{

    /**
     * @var Router
     */
    private static $instance = null;
    /**
     * @var string
     */
    public $controllerNamespace;
    /**
     * @var string
     */
    public $middlewareNamespace;
    /**
     * @var string
     */
    public $subDirectory;
    /**
     * @var array
     */
    private  $routes = [];
    /**
     * @var Route
     */
    private $currentProcededRoute;
    /**
     * @var bool
     */
    private $_404 = true;
    /**
     * @var callable
     */
    private $_404Handler;


    public function __construct($params = [])
    {
        $this->setOption($params);
        self::$instance = $this;
    }

    public function setOption($params = [])
    {
        $defaultOption = $this->getDefaultOption();

        $option = array_merge($defaultOption, $params);

        $this->controllerNamespace = $option['controllerNamespace'];
        $this->middlewareNamespace = $option['middlewareNamespace'];
        $this->subDirectory = rtrim($option['subDirectory'], "/");

        $this->setRequestUri();
    }

    private function getDefaultOption()
    {
        return [
            'controllerNamespace' => "\\App\\controller",
            'middlewareNamespace' => "\\App\\middleware",
            'subDirectory' => $this->getOrDefault(getenv('FRONTAL_CONTROLER_SUB_DIR'), "")
        ];
    }

    private function getOrDefault($mixed, $default = "")
    {
        return empty($mixed) ? $default : $mixed;
    }

    private function setRequestUri()
    {
        $_SERVER['REQUEST_URI'] = str_replace($this->subDirectory, '', $_SERVER['REQUEST_URI']);
    }

    public static function getInstance()
    {

        if (self::$instance == null) {
            self::$instance = new Router();
        }

        return self::$instance;
    }

    public function setConfig($params = [])
    {
        $this->setOption($params);
    }

    /**
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return $this
     */
    public function get($pathPattern, $mixes)
    {
        return $this->mixe('get', $pathPattern, $mixes);
    }

    /**
     * @param $method string|array
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return $this
     */
    public function mixe($method, $pathPattern, $mixes)
    {
       // die(strpos($pathPattern, "/").'jj');
       // if (strpos($pathPattern, "/") !== 1) {
       //     $pathPattern = "/" . $pathPattern;
       // }
        if (strpos($pathPattern, "/") !== 0) {
            $pathPattern = "/" . $pathPattern;
        }
        $this->currentProcededRoute = new Route($this, $method, $pathPattern, $mixes);
        $this->routes[] = $this->currentProcededRoute;

        return $this;
    }

    /**
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return $this
     */
    public function post($pathPattern, $mixes)
    {
        return $this->mixe('post', $pathPattern, $mixes);
    }

    /**
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return $this
     */
    public function put($pathPattern, $mixes)
    {
        return $this->mixe('put', $pathPattern, $mixes);
    }

    /**
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return $this
     */
    public function patch($pathPattern, $mixes)
    {
        return $this->mixe('patch', $pathPattern, $mixes);
    }

    /**
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return $this
     */
    public function delete($pathPattern, $mixes)
    {
        return $this->mixe('delete', $pathPattern, $mixes);
    }

    /**
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return $this
     */
    public function update($pathPattern, $mixes)
    {
        return $this->mixe('update', $pathPattern, $mixes);
    }

    /**
     * @param $middleware  string|string[]|callable|callable[]
     * @return $this
     */
    public function middleware($middleware)
    {
        $middlewares = is_array($middleware) ? $middleware : [$middleware];

        foreach ($middlewares as $md) {
            $this->currentProcededRoute->middlewares[] = $md;
        }

        return $this;
    }

    /**
     * @param string $sep
     * @return $this
     */
    public function separator($sep = "/")
    {
        $this->currentProcededRoute->setRouteSeparator($sep);
        return $this;
    }

    /**
     * @param $where array|string
     * @param $mixes string|null
     * @return $this
     * @throws Exception
     */
    public function regex($where, $mixes = null)
    {

        $routesParams = null;
        if ($mixes === null) {
            if (is_array($where)) {
                $routesParams = $where;
            } else {
                throw new \InvalidArgumentException('Invalid argument passed to regex');
            }
        } else {

            $routesParams = [
                $where => strval($mixes)
            ];
        }

        $this->currentProcededRoute->setRouteParams($routesParams);

        return $this;
    }

    /**
     *
     */
    public function run()
    {

        for ($i = 0; $i < count($this->routes); $i++) {

            $route = $this->routes[$i];
            if ($route->matchUrl()) {
                $this->_404 = false;
                //Mettres les parametres
                $route->prepareRunning();
                $return = $route->processMiddleware();

                if (is_string($return) || $return === false) {
                    Response::end($return);
                } else {
                    $output = $route->run();
                    Response::end($output);
                    break;
                }
            }
        }

        if ($this->_404) {
            $notFoundRoute = $_SERVER['REQUEST_URI'];

            if (is_callable($this->_404Handler)) {
                call_user_func_array($this->_404Handler, [
                    $notFoundRoute
                ]);
            } else {
                Response::withStatus(404);
                //throw new \SenRouter\Exception\Exception404NotFound("Route '{$notFoundRoute}' not found");
                echo '404 NOT FOUND';
            }
        }

        die;

    }

    /**
     * @param $handler callable
     */
    public function set404Handler($handler)
    {
        $this->_404Handler = $handler;
    }
}