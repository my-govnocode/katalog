<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div class="row justify-content-center">
        <?php $form = ActiveForm::begin(['options' => [
                'class' => 'col-md-6',
                'method' => 'post',
                'action' => Url::toRoute('auth/login')
            ]
            ]); ?>

        <?php if($session->hasFlash('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= $session->getFlash('success'); ?>
            </div>
        <?php elseif($session->hasFlash('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= $session->getFlash('error'); ?>
            </div>
        <?php endif; ?>

        <div class="row d-flex flex-column">

            <div class="form-group">
                <?= $form->field($model, 'email', ['errorOptions' => ['class' => 'text-danger']])->textInput(['placeholder' => 'Введите эл.почту'])->label('Введите эл.почту') ?>
                <div class="help-block with-errors color-warning"></div>
            </div>
            <br>

            <div class="form-group">
                <?= $form->field($model, 'password', ['errorOptions' => ['class' => 'text-danger']])->textInput(['placeholder' => 'Введите пароль'])->label('Введите пароль') ?>
                <div class="help-block with-errors"></div>
            </div>
            <br>
        </div>

        <?= Html::submitButton('Войти', ['class' => 'btn']) ?>
        <?php $form = ActiveForm::end(); ?>
</div>