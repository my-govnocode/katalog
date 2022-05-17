<?php

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
                <?= $form->field($model, 'name', ['errorOptions' => ['class' => 'text-danger']])->textInput(['value' => $product->name])->label('Название'); ?>
            </div>
            <br>

            <div class="form-group">
                <?= $form->field($model, 'price', ['errorOptions' => ['class' => 'text-danger']])->textInput(['value' => $product->price])->label('Цена'); ?>
            </div>
            <br>


            <?php foreach($groups as $group): ?>
                <?php
                $validProperty = [];
                foreach ($group->properties as $property) {
                    $validProperty[$property->id] = $property->name;
                }
                    ?>
                <?= $form->field($model, 'properties[]')->dropDownList($validProperty, ['options' => $propertiesSelected, 'prompt' => '--'])->label($group->name); ?>
            <?php endforeach; ?>
            <br>

            <div class="form-group">
                <?= $form->field($model, 'image')->fileInput(); ?>
            </div>
            <br>

            <button class="btn">Обновить</button>
        <?php ActiveForm::end(); ?>
    </div>
</div>


