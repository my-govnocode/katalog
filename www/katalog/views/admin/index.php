<?php
use app\widgets\Categories;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="container">
    <h2><a href="<?= Url::toRoute('product/create'); ?>">Добавить продукт</a></h2>
    <div class="columns">
        <div class="column col-3">
        <form action="<?= Url::toRoute('admin/index'); ?>" method='get'>
            <!-- filter -->
            <div class="filter">
                    <?php foreach($groups as $group): ?>
                        <!-- filter-item -->
                        <div class="filter-item">
                            <div class="filter-title"><?= $group->name ?></div>
                            <div class="filter-content">
                                <ul class="filter-list">
                                    <?php foreach($group->properties as $property): ?>
                                        <li>
                                            <input name="<?= Html::encode($group->code); ?>[]" value="<?= Html::encode($property->code); ?>" type="checkbox" id="filter-size-1">
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
                                <input name="priceFrom" type="number" class="price-input ui-slider-min" value="0">
                                <span class="price-sep"></span>
                                <input name="priceTo" type="number" class="price-input ui-slider-max" value="2000">
                            </div>
                            <div class="ui-slider"></div>
                            <script>
                                $('document').ready(function () {
                                    $('.ui-slider').slider({
                                        animate: false,
                                        range: true,
                                        values: [0, 2000],
                                        min: 0,
                                        max: 2000,
                                        step: 1,
                                        slide: function (event, ui) {
                                            if (ui.values[1] - ui.values[0] < 1) return false;
                                            $('.ui-slider-min').val(ui.values[0]);
                                            $('.ui-slider-max').val(ui.values[1]);
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                    <!-- filter-item -->
                    <div class="filter-item">
                        <div class="filter-content">
                            <button class="btn">Найти</button><br>
                            <button class="btn">Сбросить фильтр</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="column col-9">
            <div class="columns">
                <?php foreach($products as $product):?>
                <!--  -->
                <div class="column col-4">
                    <div class="element">
                        <div class="element-image">
                        <img src="<?= file_exists('image/products/' . $product->id . '/' . $product->image) && $product->image !== null ? 'image/products/' . $product->id . '/' . $product->image : 'https://avatars.mds.yandex.net/get-mpic/1923922/img_id3485673576547289781.jpeg/6hq' ?>" alt="">
                        </div>
                        <div class="element-title">
                            <a href=""><?= Html::encode($product->name); ?></a>
                        </div>

                        <div class="element-price"><?= Html::encode($product->price); ?> ₽</div><br>

                        <?= Html::beginForm(['product/update', 'id' => $product->id], 'PATCH'); ?>
                            <?= Html::submitButton('Обновить', ['class' => 'btn']); ?>
                        <?= Html::endForm(); ?><br>

                        <?= Html::beginForm(['product/delete', 'id' => $product->id], 'delete'); ?>
                            <?= Html::submitButton('Удалить', ['class' => 'btn']); ?>
                        <?= Html::endForm(); ?>

                    </div>
                </div>   
                <?php endforeach; ?>
            </div>
        </div>
    </div>
