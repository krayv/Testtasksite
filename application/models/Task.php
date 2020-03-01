<?php


namespace application\models;


use application\core\Database;
use application\core\Model;

class Task extends Model
{
    public $text;
    public $username;
    public $email;
    public $is_edited;
    public $is_performed;
    public static function getAllObjects()
    {
        $query = 'SELECT username, email, is_performed, is_edited, id, text FROM task';
        $db = new Database();
        $rows = $db->row($query);
        $tasks = [];
        if(!empty($rows))
        {
            foreach ($rows as $row)
            {
                $row = Task::sanitizeParams($row);
                $task = new Task();
                $task->setAttributes($row);
                $tasks[] = $task;
            }
        }
        return $tasks;
    }
    public static function isTaskExist($id)
    {
        $query = 'SELECT id FROM task WHERE id = :id';
        $db = new Database();
        $result = $db->row($query, ['id' => $id]);
        if(empty($result))
        {
            return false;
        }
        return true;
    }
    public function setAttributes($vars)
    {
        $this->email= $vars['email'];
        $this->text = $vars['text'];
        $this->username = $vars['username'];
        $this->id = $vars['id'];
        $this->is_edited = $vars['is_edited'] == 0? false: true;
        $this->is_performed = $vars['is_performed'] == 0? false: true;
    }
    public static function sanitizeParams($vars)
    {
        $vars['email'] = Model::sanitize($vars['email']) ;
        $vars['text'] = Model::sanitize($vars['text']);
        $vars['username'] = Model::sanitize($vars['username']);
        return $vars;
    }
    public function load($id)
    {
        $query = 'SELECT email, username, text, is_edited, is_performed, id FROM task WHERE id = :id';
        $result = $this->db->row($query, [ 'id' => $id]);
        if($result != null)
        {
            $result = $this->sanitizeParams($result[0]);
            $this->setAttributes($result);
            return true;
        }
        else
        {
            return false;
        }

    }
    public function validate($vars, &$errors = null)
    {
        $hasError = false;
        if(array_key_exists('email', $vars) && $vars['email'] == null)
        {
            $errors[] = "Заполните Email";
            $hasError = true;

        }
        if(array_key_exists('email', $vars) &&  $vars['email'] != null && !preg_match('/^(([a-zA-Z0-9_\.]{1,})(@)(([a-zA-Z0-9_]{1,}\.){1,2}[a-zA-Z0-9_]{1,})$)/',$vars['email']))
        {
            $errors[] = "Некорректный Email";
            $hasError = true;
        }
        if(array_key_exists('username', $vars) && $vars['username'] == null)
        {
            $errors[] = "Заполните имя";
            $hasError = true;
        }
        if(array_key_exists('text', $vars) && $vars['text'] == null)
        {
            $errors[] = "Заполните текст";
            $hasError = true;
        }

        if($hasError)
            return false;
        return true;
    }
    public function save($vars)
    {
        $vars['is_edited'] = 0;
        if(array_key_exists('is_performed', $vars))
        {
            $vars['is_performed'] = 1;
        }
        else
        {
            $vars['is_performed'] = 0;
        }
        if($this->is_edited == false && strcasecmp($this->text,$vars['text']) != 0 )
        {
            $vars['is_edited'] = 1;
        }
        $query = "UPDATE task SET text = :text, is_edited = :is_edited, is_performed = :is_performed WHERE id = :id";
        $this->db->query($query, [
            'text' => $vars['text'],
            'is_edited' => $vars['is_edited'],
            'is_performed' => $vars['is_performed'],
            'id' => $this->id,
        ]);
    }
    public function create($vars)
    {
        $query = "INSERT INTO task (text, username, email, is_edited, is_performed) VALUES (:text, :username, :email,0 ,0)";
        $this->db->query($query, [
            'text' => $vars['text'],
            'username' => $vars['username'],
            'email' => $vars['email'],
        ]);
        $this->id = $this->db->id;
    }


}