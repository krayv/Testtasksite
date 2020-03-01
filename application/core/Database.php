<?php


namespace application\core;

use PDO;
class Database
{
    protected $db;
    public $id;
    public function __construct()
    {
        $config = require 'application/config/db.php';
        $dsn = 'mysql:dbname='.$config['dbname'].';host='.$config['host'];
        $this->db = new PDO($dsn,  $config['username'] ,  $config['password'] );
    }
    public function query($sql, $args = [])
    {
        $stmt = $this->db->prepare($sql);
        if(!empty($args))
        {
            foreach ($args as $argname => $value)
            {
                $stmt->bindValue(':'.$argname, $value);
            }
        }
        $stmt->execute();
        $this->id = $this->db->lastInsertId();
        return $stmt;
    }
    public function row($query, $args = [])
    {
        $result = $this->query($query, $args);
        return $result->fetchAll(PDO::FETCH_ASSOC);

    }
}