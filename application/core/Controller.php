<?php


namespace application\core;


abstract class Controller
{
    protected $params;
    protected $view;
    protected $output;

    public function __construct($params, $output = null)
    {
        $this->params = $params;
        $this->output = $output;
        $this->view = new View($params);
    }
}