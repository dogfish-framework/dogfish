<?php
/**
 * Created by PhpStorm.
 * User: moussandour
 * Date: 31/01/2018
 * Time: 15:33
 */

namespace DogfishCore\routes;


class Routing
{
    /**
     * @var Router
     */
    private static $instance = null;
    private $router;

    /**
     * @param $method string|array
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return Router
     */
    public static function mixe($method, $pathPattern, $mixes)
    {

        return self::getInstance()->mixe($method, getBaseUrl().$pathPattern, $mixes);

    }

    /**
     * @return Router
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = Router::getInstance();
        }

        return self::$instance;
    }

    /**
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return Router
     * @internal param array|string $method
     */
    public static function get($pathPattern, $mixes)
    {
       //die(getBaseUrl().$pathPattern);
        return self::getInstance()->mixe('get', $pathPattern, $mixes);
    }

    /**
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return Router
     * @internal param array|string $method
     */
    public static function post($pathPattern, $mixes)
    {
        return self::getInstance()->mixe('post', $pathPattern, $mixes);
    }

    /**
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return Router
     * @internal param array|string $method
     */
    public static function put($pathPattern, $mixes)
    {
        return self::getInstance()->mixe('put', $pathPattern, $mixes);
    }

    /**
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return Router
     * @internal param array|string $method
     */
    public static function patch($pathPattern, $mixes)
    {
        return self::getInstance()->mixe('patch', $pathPattern, $mixes);
    }

    /**
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return Router
     * @internal param array|string $method
     */
    public static function delete($pathPattern, $mixes)
    {
        return self::getInstance()->mixe('delete', $pathPattern, $mixes);
    }

    /**
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return Router
     * @internal param array|string $method
     */
    public static function update($pathPattern, $mixes)
    {
        return self::getInstance()->mixe('update', $pathPattern, $mixes);
    }

    /**
     *
     */
    public static function run()
    {
        self::getInstance()->run();
    }
}