<?php

use yii\helpers\Html;

?>
            <?php foreach($products as $product):?>
            <!--  -->
            <div class="column col-4">
                <div class="element">
                    <div class="element-image">
                        <img src="<?= file_exists('image/products/' . $product->id . '/' . $product->image) && $product->image !== null ? Yii::$app->urlManager->createUrl('image/products/' . $product->id . '/' . $product->image) : 'https://avatars.mds.yandex.net/get-mpic/1923922/img_id3485673576547289781.jpeg/6hq' ?>" alt="">
                    </div>
                    <div class="element-title">
                        <a href=""><?= Html::encode($product->name); ?></a>
                    </div>
                    <div class="element-price"><?= Html::encode($product->price); ?> ₽</div>
                </div>
            </div>   
            <?php endforeach; ?>