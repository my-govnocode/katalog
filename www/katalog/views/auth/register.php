<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<div class="row justify-content-center">
        <?php $form = ActiveForm::begin(
            ['options' => [
                'class' => 'col-md-6',
                'method' => 'post',
                'action' => Url::toRoute('auth/register')
            ]
            ]); ?>

        <div class="row d-flex flex-column">

            <div class="form-group">
                <?= $form->field($model, 'username', ['errorOptions' => ['class' => 'text-danger']])->textInput(['placeholder' => 'Введите имя'])->label('Введите имя') ?>
            </div>
            <br>

            <div class="form-group">
                <?= $form->field($model, 'email', ['errorOptions' => ['class' => 'text-danger']])->textInput(['placeholder' => 'Введите эл.почту'])->label('Введите эл.почту') ?>
            </div>
            <br>

            <div class="form-group">
                <?= $form->field($model, 'password', ['errorOptions' => ['class' => 'text-danger']])->textInput(['placeholder' => 'Введите пароль'])->label('Введите пароль') ?>
            </div>
            <br>

            <div class="form-group">
                <?= $form->field($model, 'password_confirm', ['errorOptions' => ['class' => 'text-danger']])->textInput(['placeholder' => 'Повторите пароль'])->label('Повторите пароль') ?>
            </div>
            <br>

            <?= Html::submitButton('Отправить', ['class' => 'btn']) ?>
        </div>
        <?php $form = ActiveForm::end(); ?>
</div>