<?php

use app\models\Product;
use yii\helpers\Url;
use yii\helpers\Html;
?>

<?php $this->registerJsFile('js/filterProducts.js', ['position'=>\yii\web\View::POS_END]); ?>

<div class="columns">
    <div class="column col-3">
    <form id="form" action="<?= Url::toRoute('product/index') ?>" method='get'>
        <!-- filter -->
        <div class="filter">
                <?php foreach($groups as $group): ?>
                    <!-- filter-item -->
                    <div class="filter-item">
                        <div class="filter-title"><?= Html::encode($group->name); ?></div>
                        <div class="filter-content">
                            <ul class="filter-list">
                                <?php foreach($group->propertiesProducts as $property): ?>
                                    <li>
                                        <input class="productFilter" id="<?= Html::encode($property->code)?>" name="<?= Html::encode($group->code)?>[]" value="<?= Html::encode($property->code); ?>"  type="checkbox">
                                        <label for="filter-size-1"><?= Html::encode($property->name); ?></label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- filter-item -->
                <div class="filter-item">
                    <div class="filter-title">Цена</div>
                    <div class="filter-content">
                        <div class="price">
                            <input type="number" name="priceFrom" class="price-input ui-slider-min" value="<?= Product::PRICE_MIN; ?>">
                            <span class="price-sep"></span>
                            <input type="number" name="priceTo" class="price-input ui-slider-max" value="<?= Product::PRICE_MAX; ?>">
                        </div>
                       
                        <!-- <div class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                            <div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div>
                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span>
                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span>
                        </div>
                        <script>
                            $('document').ready(function () {
                                $('.ui-slider').slider({
                                    animate: false,
                                    range: true,
                                    values: [1, 2000],
                                    min: 1,
                                    max: 2000,
                                    step: 1,
                                    slide: function (event, ui) {
                                        if (ui.values[1] - ui.values[0] < 1) return false;
                                        $('.ui-slider-min').val(ui.values[0]);
                                        $('.ui-slider-max').val(ui.values[1]);
                                    }
                                });
                            });
                        </script> -->
                    </div>
                </div>
                <!-- filter-item -->
                <div class="filter-item">
                    <div class="filter-content">
                        <a id="clearFilter" href="<?= Url::toRoute('product/index'); ?>" class="btn">Сбросить фильтр</a>
                        <button style="display: none" id="submit" class="btn">Найти</button>
                    </div>
                </div>
            </div>
        </div>
    </form>