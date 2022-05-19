<?php
use app\models\Product;
use yii\helpers\Html;
?>

<?php $this->registerJsFile(Yii::$app->urlManager->createUrl('js/filterProducts.js'), ['position'=>\yii\web\View::POS_END]); ?>
<div class="columns">
    <div class="column col-3">
    <form id="form" action="<?= Yii::$app->urlManager->createUrl($url); ?>" method='get'>
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
                    </div>
                </div>
                <!-- filter-item -->
                <div class="filter-item">
                    <div class="filter-content">
                        <a id="clearFilter" href="<?= $url; ?>" class="btn">Сбросить фильтр</a>
                        <button style="display: none" id="submit" class="btn">Найти</button>
                    </div>
                </div>
            </div>
        </div>
    </form>