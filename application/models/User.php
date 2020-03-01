<?php

namespace application\models;

use application\core\Model;

class User extends Model
{
    public $email;
    public $username;
    public $id;
    public $is_admin;
    public function login($vars)
    {
        $query = 'SELECT id, is_admin FROM user WHERE username = :username and password = :password';
        $result = $this->db->row($query,[
            'username' => $vars['username'],
            'password' => $vars['password'],
        ]);
        if(empty($result))
        {
            return false;
        }
        $this->id = $result[0]['id'];
        $this->is_admin = $result[0]['is_admin'] == 0? false: true;
        return true;
    }
    public function validate($vars, &$errors = null)
    {
        $hasError = false;
        if(array_key_exists('username', $vars) && $vars['username'] == null)
        {
            $errors[] = "Заполните логин";
            $hasError = true;
        }
        if(array_key_exists('password', $vars) && $vars['password'] == null)
        {
            $errors[] = "Заполните пароль";
            $hasError = true;
        }
        if($hasError)
            return false;
        return true;
    }
}