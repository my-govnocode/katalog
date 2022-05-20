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
<div class="wraper">
<div class="header bg-black text-white" style="border-bottom: black;">
        <div class="container d-flex justify-content-between">
        	<h3><a class="text-white" href="<?= Url::toRoute('product/index') ?>">Каталог</a></h3>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                            <strong><?= \Yii::$app->user->identity->username; ?></strong>
                        </a>
                        <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                        <?php if(Yii::$app->user->can('admin')): ?>
                            <li><a class="dropdown-item" href="<?= Url::toRoute('product/create'); ?>">Добавить продукт</a></li>
                            <li><a class="dropdown-item" href="<?= Url::toRoute('admin/index'); ?>">Админка</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= Url::toRoute('auth/logout'); ?>">Выйти</a></li>
                        </ul>
                        </div>
                    </div>
        </div>
    </div>

<div class="row  d-flex">
<div class="d-flex justify-content-center col-md-2 flex-column p-3 text-white bg-dark">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <span class="fs-4">Админка</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li>
        <a href="#" class="nav-link text-white">
          Главная
        </a>
      </li>
      <li>
        <a href="#" class="nav-link text-white">
          Продукты
        </a>
      </li>
      <li>
        <a href="#" class="nav-link text-white">
          Пользователи
        </a>
      </li>
    </ul>
  </div>


    <div class="wrap col-md-9">
        <div class="container">
            

            <?= $content ?>

        </div>
    </div>
    </div>
    </div>
</div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
