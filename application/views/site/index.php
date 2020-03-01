<?php
function addOrderToUrl($order, $pagination, $sorted)
{
    $string = '';
    if($sorted['isSorted'] == true && $sorted['typeOrder'] == 'orderByAscending' && $sorted['column'] == $order)
    {
        $string = 'orderByDescending='.$order;
    }
    else
    {
        $string = 'orderByAscending='.$order;
    }
    if($pagination != 1)
    {
        return '?pagination='.$pagination.'&'.$string;
    }
    return '?'.$string;
}
function addPaginationToUrl($page, $sorted)
{
    if($sorted['isSorted'] == true)
    {
        return '?pagination='.$page.'&'.$sorted['typeOrder'].'='.$sorted['column'];
    }
    return '?pagination='.$page;
}
?>
<div class="panel">
    <?php if(!isset($_SESSION['UserId']) || $_SESSION['UserId'] == null):?>
        <a href = 'login'><button type="button" class="btn btn-secondary">Войти</button></a>
    <?php else:?>
        <a href = 'logout'><button type="button" class="btn btn-secondary">Выйти</button></a>
    <?php endif;?>
    <a href = 'task/new'><button type="button" class="btn btn-secondary">Создать задание</button></a>
    <div class="panel-default">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <th><a href=<?=addOrderToUrl('username', $pagination, $sorted)?>>Имя пользователя</a></th>
                    <th><a href=<?=addOrderToUrl('email', $pagination, $sorted)?>>Email</a></th>
                    <th><a href=<?=addOrderToUrl('text', $pagination, $sorted)?>>Сообщение</th>
                    <th><a href=<?=addOrderToUrl('is_performed', $pagination, $sorted)?>>Статус</th>
                </tr>
                <?php foreach ($vars as $task):?>
                     <tr>
                        <td>
                            <a href=<?='task/?id='.$task->id?>><?=$task->username?></a>
                        </td>
                        <td>
                            <a href=<?='task/?id='.$task->id?>><?=$task->email?></a>
                        </td>
                        <td>
                            <a href=<?='task/?id='.$task->id?>><?=$task->text?></a>
                        </td>
                        <td>
                            <?php if($task->is_performed == 1):?> Выполнено &nbsp;<?php else:?> Создан <?php endif;?>
                            <?php if($task->is_edited == 1):?> отредактировано администратором <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if($pagination-1 != 0):?>
                        <li class="page-item">
                            <a class="page-link" href=<?=addPaginationToUrl($pagination-1, $sorted);?> aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href= <?= addPaginationToUrl($pagination-1, $sorted);?>> <?=$pagination-1;?> </a></li>
                    <?php endif;?>
                    <li class="page-item"><a class="page-link"><?=$pagination;?></a></li>
                    <?php if($pagination + 1 <= $maxPagination):?>
                        <li class="page-item"><a class="page-link" href = <?= addPaginationToUrl($pagination+1, $sorted); ?>> <?=$pagination+1;?> </a></li>
                        <li class="page-item">
                            <a class="page-link" href=<?=addPaginationToUrl($pagination + 1, $sorted);?> aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    <?php endif;?>
                </ul>
            </nav>
        </div>
    </div>
</div>
