<?php


namespace application\core;


class View
{
    protected $params;
    protected $layout = 'default.php';
    public function __construct($params)
    {
        $this->params = $params;
    }
    public function render($title, $vars = [], $args = [])
    {
        $path = 'application/views/'.$this->params['controller'].'/'.$this->params['action'].'.php';
        if(file_exists($path))
        {
            extract($vars);
            extract($args);
            ob_start();
            require $path;
            $content = ob_get_contents();
            ob_end_clean();
            require 'application/views/layout/'.$this->layout;
        }
    }
    public function redirect($url)
    {
        header('location: '.$url);
    }
    public static function error($code)
    {
        http_response_code($code);
        $errorPath = 'application/views/errors/'. $code.'.php';
        if(file_exists($errorPath))
        {
            require $errorPath;
        }
        exit;
    }
    public function refresh()
    {
        header("Refresh:0");
        exit;
    }
}