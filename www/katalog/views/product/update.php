<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

    <div class="row">
        <div class="col-md-4">
            <?php $form = ActiveForm::begin([
                'action' => '/products',
                'method' => 'post',
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>

                <div class="form-group">
                    <?= $form->field($model, 'name')->textInput()->label('Название'); ?>
                </div>
                <br>

                <div class="form-group">
                    <?= $form->field($model, 'price')->label('Цена'); ?>
                </div>
                <br>


                <?php foreach($groups as $group): ?>
                    <h4><?= $group->name; ?></h3>
                    <?php
                    $validProperty = [];
                    foreach ($group->propertys as $property) {
                        $validProperty[(int)$property->id] = $property->name;
                    }
                     ?>
                    <?= $form->field($model, 'propertys[]')->dropDownList($validProperty); ?>
                <?php endforeach; ?>
                <br>

                <div class="form-group">
                    <?= $form->field($model, 'image')->fileInput(); ?>
                </div>
                <br>

                <button class="btn">Создать</button>
            <?php ActiveForm::end(); ?>
        </div>
    </div>


