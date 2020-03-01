<?php

namespace application\controllers;

use application\core\Controller;
use application\models\Task;
use application\models\User;

class SiteController extends Controller
{
    public function indexAction()
    {
        $tasks = Task::getAllObjects();
        $argc['sorted'] = [
            'isSorted' => false
        ];
        if(!empty($this->output))
        {
            if(array_key_exists('orderByAscending', $this->output) && is_string($this->output['orderByAscending']) && array_key_exists($this->output['orderByAscending'], get_object_vars(new Task())))
            {
                $argc['sorted'] =  [
                        'typeOrder' => 'orderByAscending',
                        'column' => $this->output['orderByAscending'],
                        'isSorted' => true
                    ];
                usort($tasks, function ($comparator, $compared)
                {
                    return  strcmp($comparator->{$this->output['orderByAscending']}, $compared->{$this->output['orderByAscending']});
                });
            }
            if(array_key_exists('orderByDescending', $this->output) && is_string($this->output['orderByDescending']))
            {
                $argc['sorted'] = [
                        'typeOrder' => 'orderByDescending',
                        'column' => $this->output['orderByDescending'],
                        'isSorted' => true
                    ];
                usort($tasks, function ($comparator, $compared)
                {
                    return strcmp($compared->{$this->output['orderByDescending']}, $comparator->{$this->output['orderByDescending']});
                });
            }
        }
        $taskPage = [];
        $pagination = 1;
        $countObjects = 3;
        if(!empty($tasks))
        {
            if (!empty($this->output) && array_key_exists('pagination', $this->output) && is_numeric($this->output['pagination']))
            {
                $pagination = $this->output['pagination'];
            }
            for ($i = (($pagination - 1) * $countObjects) ; $i < (($pagination - 1) * $countObjects + $countObjects)  && $i < count($tasks); $i++) {
                $taskPage[] = $tasks[$i];
            }
        }
        $argc['pagination'] = $pagination;
        $argc['maxPagination'] = intval(ceil(count($tasks) / $countObjects));
        $this->view->render('Главная',$taskPage, $argc);
    }
    public function loginAction()
    {
        $errors =
            [
                'errors' => []
            ];
        if($_POST)
        {
            $user = new User();
            if($user->validate($_POST, $errors['errors']))
            {
                if ($user->login($_POST))
                {
                    $_SESSION['UserId'] = $user->id;
                    $this->view->redirect('index');
                }
                else
                {
                    $errors['errors'] = ["Неверый логин или пароль"];
                }
            }
        }
        $this->view->render('Вход', $errors);
    }
    public function logoutAction()
    {
        $_SESSION['UserId'] = null;
        $this->view->redirect('index');
    }
}