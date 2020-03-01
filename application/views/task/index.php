<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 well">
            <a href="../../"><h4>На главную</h4></a>
            <div class="form-group">
                <textarea type="text" class="form-control" readonly> <?=$username?></textarea>
            </div>
            <div class="form-group">
                <textarea type="text" class="form-control" readonly> <?=$email?></textarea>
            </div>
            <?php if(isset($_SESSION['UserId']) && $_SESSION['UserId'] != null): ?>
                <form method="post" action= <?='?id='.$id?>>
                    <div class="form-group">
                        <textarea type="text" class="form-control" name="text" rows = 4><?=$text?></textarea>
                    <label for="is_performed">Выполнено</label>
                    <input type="checkbox" name="is_performed"<?php if($is_performed == 1):?> checked <?php endif;?> >
                    <div class="text-left">
                        <button class="btn btn-default" type="submit">Сохранить</button>
                    </div>
                </form>
            <?php else: ?>
                <div class="form-group">
                    <textarea type="text" class="form-control"  rows = 4 readonly><?=$text?></textarea>
                </div>
                <label for="is_performed">Выполнено</label>
                <input type="checkbox" <?php if($is_performed == 1):?> checked <?php endif;?> disabled>
                <input type="hidden" name="option" value="1">
            <?php endif; ?>
            <?php foreach($errors as $error):?>
                <li><?=$error?></li>
            <?php endforeach;?>
        </div>
    </div>
</div>
<?php if(array_key_exists('new',$message) && $message['new'] != null):?>
    <script language="javascript">
        alert('Задание создано')
    </script>
<?php endif;?>
<?php if(array_key_exists('saved',$message) && $message['saved'] != null):?>
    <script language="javascript">
        alert('Изменения сохранены')
    </script>
<?php endif;?>