<?php

namespace DogfishCore\routes;

use Exception;
use DogfishCore\http\Request;

class Route
{

    /**
     * @var array
     */
    public $middlewares = [];
    /**
     * @var array
     * les methode du requette passe en paramettre, enregistre les ou le methode get ou post ...
     */
    private $allowedMethod = [];
    /**
     * @var string
     */
    private $pathPattern;
    /**
     * @var string
     */
    private $currentRoute;
    /**
     * @var bool
     */
    private $caseSensitive;
    /**
     * @var array
     * Recupere les paramettre passe dans le pattern
     */
    private $routeParams = [];
    /**
     * @var string
     */
    private $routeSeparator = "/";
    /**
     * @var string
     */
    private $routeWithRegex;
    /**
     * @var string|callable
     * le controller et la methode en chaine de caractere separee par un @ ou une function
     */
    private $mixes;
    /**
     * @var array
     */
    private $paramsKeys = [];
    /**
     * @var array
     */
    private $paramsKeysRegex = [];
    /**
     * @var array
     */
    private $paramsValues = [];
    /**
     * @var bool
     */
    private $haveSetedParams = false;
    /**
     * @var
     */
    private $router;
    /**
     * @var
     */
    private $output;

    public function __construct($router, $method, $pathPattern, $mixes, $caseSensitive = false)
    {
        $this->router = $router;
        $this->currentRoute = rtrim( $_SERVER['REQUEST_URI'], $this->routeSeparator);
        ///
        $this->currentRoute = str_replace("?{$_SERVER['QUERY_STRING']}", "", $this->currentRoute);
        $this->pathPattern = rtrim($pathPattern, $this->routeSeparator);
        $this->setAllowedMethod($method);
        $this->mixes = $mixes;
        $this->caseSensitive = $caseSensitive;
    }

    /**
     * @param $method
     */
    private function setAllowedMethod($method)
    {
        $methods = [];

        if (is_string($method)) {
            $methods[] = $method;
        } else if (is_array($method)) {
            $methods = $method;
        }
        /**
         * getAllHttpMethod donne l'ensemble des methode de requette autorisee par le systeme
         */
        foreach ($methods as $value) {
            if (in_array($value, Request::getAllHttpMethod())) {
                $this->allowedMethod[] = strtolower($value);
            }
        }
    }

    /**
     * @return bool
     */
    public function matchUrl()
    {
        if (!$this->haveSetedParams) {
            $this->setRouteParams($this->paramsKeysRegex);
        }

        try {
            return preg_match($this->routeWithRegex, $this->currentRoute)
                && in_array(Request::getRequestMethod(), $this->allowedMethod);
        } catch (Exception $e) {
            throw new \Exception("Invalide route regex for route {$this->pathPattern}");
        }
    }

    /**
     * @param $routeParams
     */
    public function setRouteParams($routeParams)
    {
        $this->setRouteParamsKeysRegex();
        $this->routeWithRegex = preg_quote($this->pathPattern);
        $this->routeParams = array_merge($this->paramsKeysRegex, $routeParams);

        foreach ($this->routeParams as $name => $regex) {
            if ($regex === "*" || empty($regex)) {
                $regex = ".*";
            }

            $this->routeWithRegex = str_replace('\\{' . $name . '\\}', '(' . $regex . ')', $this->routeWithRegex);

        }

        $this->routeWithRegex = "#^" . $this->routeWithRegex . '$#'; // .'(\?.*)?$#'
        $this->haveSetedParams = true;
    }

    /**
     *
     */
    public function setRouteParamsKeysRegex()
    {

        $this->setRouteParamsKeys();
        foreach ($this->paramsKeys as $key => $value) {
            $value = str_replace('{', '', $value);
            $value = str_replace('}', '', $value);
            $this->paramsKeysRegex[$value] = "[^{$this->getRouteSeparator()}]*";;// change'.*';
        }
    }

    /**
     *
     */
    public function setRouteParamsKeys()
    {
        $match = [];
        $start = "[a-z-A-Z_]{1}";
        $follow = "[a-z-A-Z_0-9]+";

        preg_match_all('#\\{' . $start . $follow . '\\}#', $this->pathPattern, $match);
        array_walk($match[0], function (&$value) {
            $value = str_replace('{', '', $value);
            $value = str_replace('}', '', $value);
        });

        $this->paramsKeys = $match[0];
    }

    /**
     * @return string
     */
    public function getRouteSeparator()
    {
        return $this->routeSeparator;
    }

    /**
     * @param $routeSeparator
     * @throws Exception
     */
    public function setRouteSeparator($routeSeparator)
    {
        if (in_array($routeSeparator, ["/", ".", "-"])) {
            $this->routeSeparator = $routeSeparator;
        } else {
            throw new \InvalidArgumentException("Invalid route separator");
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        if (is_callable($this->mixes)) {
            $this->output = $this->callCosure($this->mixes, $this->paramsValues);
        } else {
            $this->output = $this->callController($this->mixes, $this->paramsValues, $this->router->controllerNamespace);
        }

        return $this->output;
    }

    /**
     * @param $mixes callable
     * @param $paramsValues array
     * @return mixed
     */
    public function callCosure($mixes, $paramsValues)
    {
        try {
            return call_user_func_array($mixes, $paramsValues);
        } catch (\ArgumentCountError $e) {
            throw new \InvalidArgumentException("'Defined route separator and route separator in URL dont match'");
        }
    }

    /**
     * @param $mixes string
     * @param $paramsValues
     * @param $namespace
     * @return mixed
     */
    public function callController($mixes, $paramsValues, $namespace)
    {
        $len = intval(strpos($mixes, '@'));
        $controller = $namespace . '\\' . substr($mixes, 0, $len);
        $action = substr($mixes, $len + 1);

        $class = new $controller();

        try {
            $return = call_user_func_array([$class, $action], $paramsValues);
        } catch (\ArgumentCountError $e) {
            throw new \InvalidArgumentException("'Defined route separator and route separator in URL dont match'");
        }

        return $return;

    }

    /**
     * @return bool|mixed
     */
    public function processMiddleware()
    {
        foreach ($this->middlewares as $middleware) {

            if (is_callable($middleware)) {
                $return = $this->callCosure($middleware, $this->paramsValues);
            } else {
                $return = $this->callController($middleware, $this->paramsValues, $this->router->middlewareNamespace);;
            }

            if (is_string($return) || $return === false) {
                return $return;
            }
        }

        return true;
    }

    /**
     *
     */
    public function prepareRunning()
    {
        $this->setRouteParamsValues();
    }

    /**
     *
     */
    public function setRouteParamsValues()
    {
        $splitedUri = explode($this->routeSeparator, $this->currentRoute);
        $splitedPattern = explode($this->routeSeparator, $this->pathPattern);
        $i = 0;

        foreach ($splitedUri as $value) {
            if (!in_array($value, $splitedPattern)) {
                $this->paramsValues[$this->paramsKeys[$i++]] = $value;
            }
        }
    }

}