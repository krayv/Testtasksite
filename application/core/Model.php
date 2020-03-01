<?php


namespace application\core;


class Model
{
    public $db;
    public $id;

    public function __construct()
    {
        $this->db = new Database();
    }
    public static function sanitize($string){
        $string = stripslashes($string);
        $string = htmlentities($string);
        $string = htmlspecialchars($string, ENT_QUOTES);
        return($string);
    }

}