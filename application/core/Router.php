<?php
namespace application\core;

class Router
{
    private $params;
    private $routes;
    private $output;
    public function __construct()
    {
        $routes = require 'application/config/routes.php';
        foreach ($routes as $route => $value)
        {
            $this->add($route, $value);
        }
    }
    private function add($route, $params)
    {
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }
    protected function match()
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        if(strstr($uri, "?"))
        {
            $this->id = substr(strstr($uri, "?"), 1);
            parse_str($this->id,$output);
            $this->output = $output;
            $uri = trim(strstr($uri, "?", -1), '/');
        }
        foreach ($this->routes as $route => $value)
        {
            if(preg_match($route, $uri))
            {
                $this->params = $value;
                return true;
            }
        }
        return false;
    }
    public function run()
    {
        if($this->match())
        {
            $path = 'application\controllers\\'.ucfirst($this->params['controller']).'Controller';
            if(class_exists($path, true))
            {
                $action = $this->params['action'].'Action';
                if(method_exists($path, $action))
                {
                    $controller = new $path($this->params, $this->output);
                    $controller->$action();
                }
                else
                {
                    View::error(404);
                }
            }
            else
            {
                View::error(404);
            }
        }
        else
        {
            View::error(404);
        }
    }

}