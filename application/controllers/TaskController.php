<?php


namespace application\controllers;


use application\core\Controller;
use application\core\View;
use application\models\Task;

class TaskController extends Controller
{
    public function indexAction()
    {
        $errors =
            [
                'errors' => [],
                'message'=> []
            ];
        if(empty($this->output) || !array_key_exists('id', $this->output) || $this->output['id'] == null || !Task::isTaskExist($this->output['id']))
        {
                View::error(404);
        }
        if(isset($this->output['isNew']))
        {
            $errors['message']['new'] = "Задание создано";
        }
        if(isset($this->output['isSaved']))
        {
            $errors['message']['saved'] = "Сохранено";
        }
        $task = new Task();
        $task->load($this->output['id']);
        if($_POST)
        {
            if(isset($_SESSION['UserId']) && $_SESSION['UserId'] != null)
            {
                if($task->validate($_POST, $errors['errors']))
                {
                    $task->save($_POST);
                    $this->view->redirect('?id='.$task->id.'&isSaved=true');
                }
            }
            else
            {
                $errors['errors'][] = "Вы не авторизованы";
            }
        }
        $this->view->render('Задача', get_object_vars($task), $errors);
    }
    public function newAction()
    {
        $vars = [
            'errors' => [],
            ];
        if($_POST)
        {
            $task = new Task();
            if($task->validate($_POST, $vars['errors']))
            {
                $task->create($_POST);
                $this->view->redirect('index/?id='.$task->id.'&isNew=true');
            }
        }
        $this->view->render('Задача', $vars);
    }
}