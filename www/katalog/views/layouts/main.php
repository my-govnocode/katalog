<?php

use app\assets\AppAsset;
use yii\bootstrap4\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<div class="wrapper">
    <div class="header">
        <div class="container d-flex justify-content-between">
        	<h3><a href="<?= Url::toRoute('product/index') ?>">Каталог</a></h3>
                <?php if(\Yii::$app->user->identity){ ?>
                        <div class="dropdown col-md-2">
                            <div class="row">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= \Yii::$app->user->identity->username; ?>
                                </button>
                                <ul class="dropdown-menu col-md-12" aria-labelledby="dropdownMenuButton1">
                                    <?php if(Yii::$app->user->can('admin')): ?>
                                        <li><a class="dropdown-item" href="<?= Url::toRoute('product/create'); ?>">Добавить продукт</a></li>
                                        <li><a class="dropdown-item" href="<?= Url::toRoute('admin/index'); ?>">Админка</a></li>
                                    <?php endif; ?>
                                    <li><a class="dropdown-item" href="<?= Url::toRoute('auth/logout'); ?>">Выйти</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="login col-md-3">
                            <div class="row">
                                <h3 class="col-md-6"><a href="<?= Url::to('login') ?>">Войти</a></h3>
                                <h3 class="col-md-6"><a href="<?= Url::to('register') ?>">Регистрация</a></h3>
                            </div>
                        </div>
                    <?php } ?>
        </div>
    </div>
    <div class="wrap">
        <div class="container">

            <?= $content ?>

        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
