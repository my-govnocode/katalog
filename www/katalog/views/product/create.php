<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

    <div class="row">
        <div class="col-md-4">
            <?php $form = ActiveForm::begin([
                'action' => Url::toRoute(['product/index']),
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


                <?php foreach($groups as $group) {
                    $validProperty = [];
                    foreach ($group->properties as $property) {
                        $validProperty[$property->id] = $property->name;
                    }
                    echo $form->field($model, 'properties[]')->dropDownList($validProperty, ['prompt' => '--'])->label($group->name);
                }?>
                <br>

                <div class="form-group">
                    <?= $form->field($model, 'image')->fileInput(); ?>
                </div>
                <br>

                <button class="btn">Создать</button>
            <?php ActiveForm::end(); ?>
        </div>
    </div>


