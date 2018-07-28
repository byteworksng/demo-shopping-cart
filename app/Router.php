<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 28/06/2018
 * Time: 3:10 AM
 */

namespace App;

use App\Interfaces\BootstrapInterface;
use App\Interfaces\DiInterface;
use App\Interfaces\RouteInterface;

/**
 * Class Router
 *
 * @package App
 */
class Router implements RouteInterface, BootstrapInterface
{
    use Traits\Logger;

    /**
     * @var
     */
    private $controller;

    /**
     * @var
     */
    private $action;

    /**
     * @var
     */
    private $params;

    /**
     * @var
     */
    private $routes;

    /**
     * @var \App\Interfaces\DiInterface
     */
    private $container;

    /**
     * @var
     */
    private $requestUri;

    /**
     * @var
     */
    private $requestMethod;

    /**
     * @var null
     */
    private $query;

    /**
     * Router constructor.
     *
     * @param                             $routes
     * @param \App\Interfaces\DiInterface $container
     */
    public function __construct($routes, DiInterface $container)
    {
        $this->container = $container;
        $this->routes = $routes;
        $this->requestUri = $_SERVER["REQUEST_URI"];
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];
        $this->query = isset($_SERVER["QUERY_STRING"]) ? $_SERVER["QUERY_STRING"] : null;
    }

    /**
     * @return mixed
     */
    public function run()
    {
        try
        {
            return $this->process();
        } catch (\Exception $e)
        {
            $this->errorHandler($e);
        }
    }

    /**
     * @param \Exception $exception
     */
    public function errorHandler(\Exception $exception)
    {

        switch ($exception->getCode())
        {
            case 404:
                header("HTTP/1.1 404 Not Found");
                break;
            case 401:
                header("HTTP/1.1 401 Unauthorized");
                break;
            case 403:
                header("HTTP/1.1 403 Forbidden");
                break;
            case 405:
                header("HTTP/1.1 405 Method Not Allowed");
                break;
            default:
                header("HTTP/1.1 500 Internal Server Error");
        }
        $this->log($exception);
        die();
    }

    /**
     * @return mixed
     * @throws \ErrorException
     */
    protected function process()
    {
        return $this->match()->dispatch();
    }

    /**
     *
     */
    public function match()
    {
        $requestUri = $this->parseUri();
        $method = strtolower($this->requestMethod);

        foreach ($this->routes[$method] as $path => $controllerAction)
        {

            //what if parameters exist
            if ($this->matchRoute($requestUri, $path))
            {
                $this->prepareForDespatch($controllerAction);
                break 1;
            }

            // when no parameters exist
            continue;
        }
        return $this;
    }

    /**
     * @param null $requestUri
     *
     * @return string
     */
    public function parseUri($requestUri = null)
    {
        if (isset($requestUri))
        {
            $path = trim(parse_url($requestUri, PHP_URL_PATH));
        } else
        {
            $path = trim(parse_url($this->requestUri, PHP_URL_PATH));
        }

        return $path;
    }

    /**
     * @param $requestPath
     * @param $routePath
     *
     * @return bool
     */
    public function matchRoute($requestPath, $routePath)
    {
        $pathItems = explode('/', $routePath);
        $requestUriItems = explode('/', $requestPath);
        $params = [];

        if (sizeof($pathItems) == sizeof($requestUriItems))
        {

            array_walk($pathItems, function (&$val, $idx) use ($requestUriItems, &$params) {
                if ($val != $requestUriItems[$idx] && preg_match('/^{\w+}$/', $val))
                {
                    $key = strtr($val, ['{' => '', '}' => '']);
                    $params[$key] = $requestUriItems[$idx];
                    $val = $requestUriItems[$idx];
                }
            });

            $path = implode('/', $pathItems);
            $requestUri = implode('/', $requestUriItems);

            if ($path == $requestUri)
            {
                $this->setParam($params);
                $this->parseQueryParam();
                $this->parseQuerySegment();

                return true;
            }
        }

        return false;
    }

    /**
     * @param array $params
     *
     * @return $this
     */
    public function setParam(array $params)
    {

        $this->params = $params;

        return $this;
    }

    /**
     * @param null $query
     *
     * @return array
     */
    public function parseQueryParam($query = null)
    {
        $queryParams = [];
        if (isset($query))
        {
            parse_str($query, $queryParams);
        } else
        {
            ! isset($this->query) ?: parse_str($this->query, $queryParams);
        }

        return $queryParams;
    }

    /**
     * @param null $query
     *
     * @return mixed
     */
    public function parseQuerySegment()
    {

        $querySegment = parse_url($this->requestUri, PHP_URL_FRAGMENT);

        return $querySegment;
    }

    /**
     * @param $match
     *
     * @return $this
     */
    public function prepareForDespatch($match)
    {
        list($controller, $action) = explode('@', $match);
        try
        {
            $this->setController($controller)->setAction($action);
        } catch (\Exception $e)
        {
            $this->errorHandler($e);
        }
        return $this;
    }

    /**
     * @param $action
     *
     * @return $this
     * @throws \ReflectionException
     */
    public function setAction($action)
    {

        $this->action = $action;

        return $this;
    }

    /**
     * @param $controller
     *
     * @return $this
     */
    public function setController($controller)
    {

        if ( ! class_exists(ucfirst($controller)))
        {
            throw new \InvalidArgumentException("No controller called $controller found", 500);
        }

        $this->controller = $controller;

        return $this;
    }

    /**
     * @return mixed
     * @throws \ErrorException
     */
    public function dispatch()
    {

        if ( ! isset($this->controller))
        {
            throw new \ErrorException('resource not found', 404);
        }

        if ($instance = $this->container->getShared($this->controller))
        {
            return $instance->callAction($this->action, $this->params);
        };

        return (new $this->controller)->callAction($this->action, $this->params);
    }

    /**
     * @param array ...$params
     */
    public function setQueryParam(...$params)
    {
        // TODO: Implement setParam() method.
    }
}
