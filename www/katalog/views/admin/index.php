<?php

use app\widgets\Categories;
use yii\helpers\Html;
use yii\helpers\Url;
?>

    <?= Categories::widget(['url' => Url::toRoute('admin/index')]); ?>

        <div class="column col-9">
            <?php if($session->hasFlash('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= $session->getFlash('success'); ?>
                </div>
            <?php elseif($session->hasFlash('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $session->getFlash('error'); ?>
                </div>
            <?php endif; ?>
            <div id="products" class="columns">
                <?= $this->render('products', ['products' => $products]); ?>
            </div>
        </div>
    </div>
