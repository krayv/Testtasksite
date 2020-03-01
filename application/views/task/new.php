<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 well">
            <a href="../../"><h4>На главную</h4></a>
            <form method="post" action="new">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Введите ваше имя" name="username" <?php if($_POST):?> value = <?=$_POST['username']?> <?php endif;?>>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Введите email" name="email" <?php if($_POST):?> value = <?=$_POST['email']?> <?php endif;?>>
                </div>
                <div class="form-group">
                    <textarea type="text" class="form-control" placeholder="Введите текст" name="text" rows = 4><?php if($_POST):?><?=$_POST['text']?><?php endif;?></textarea>
                </div>
                <div class="text-left">
                    <button class="btn btn-default" type="submit">Создать</button>
                </div>
                <ul>
                    <?php foreach($errors as $error):?>
                        <li><?=$error?></li>
                    <?php endforeach;?>
                </ul>
            </form>
        </div>
    </div>
</div>