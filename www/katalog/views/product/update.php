<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

    <div class="row">
        <div class="col-md-4">
            <?php $form = ActiveForm::begin([
                'action' => Url::toRoute(['product/update', 'id' => $product->id]),
                'method' => 'put',
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>

                <div class="form-group">
                    <?= $form->field($model, 'name')->textInput(['value' => $product->name])->label('Название'); ?>
                </div>
                <br>

                <div class="form-group">
                    <?= $form->field($model, 'price')->textInput(['value' => $product->price])->label('Цена'); ?>
                </div>
                <br>


                <?php foreach($groups as $group): ?>
                    <h4><?= $group->name; ?></h3>
                    <?php
                    $validProperty = [];
                    foreach ($group->propertys as $property) {
                        $validProperty[$property->id] = $property->name;
                    }
                     ?>
                    <?= $form->field($model, 'propertys[]')->dropDownList($validProperty, ['options' => $propertysSelected, 'prompt' => '--']); ?>
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


