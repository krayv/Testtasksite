<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 well">
            <a href="."><h4>На главную</h4></a>
            <form class="form" method="post" action="login">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Введите логин" name="username">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Введите пароль" name="password">
                </div>
                <div class="text-center">
                    <button class="btn btn-default" type="submit">Войти</button>
                </div>
            </form>
            <?php foreach($errors as $error):?>
                <li><?=$error?></li>
            <?php endforeach;?>
        </div>
    </div>
</div>