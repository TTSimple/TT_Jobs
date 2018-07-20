<?php

namespace Core\AbstractInterface;

use Core\Http\Request;
use Core\Http\Response;
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;

abstract class ARouter
{
    protected $isCache = false;
    protected $cacheFile;
    private $routeCollector;

    function __construct()
    {
        $this->routeCollector = new RouteCollector(new Std(), new GroupCountBased());
        $this->register($this->routeCollector);
    }

    abstract function register(RouteCollector $routeCollector);

    function getRouteCollector()
    {
        return $this->routeCollector;
    }

    function request()
    {
        return Request::getInstance();
    }

    function response()
    {
        return Response::getInstance();
    }
}