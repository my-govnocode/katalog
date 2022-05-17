<?php
use yii\helpers\Html;
?>
<?php foreach($products as $product):?>
    <!--  -->
    <div class="column col-4">
        <div class="element">
            <div class="element-image">
            <img src="<?= file_exists('image/products/' . $product->id . '/' . $product->image) && $product->image !== null ? '/image/products/' . $product->id . '/' . $product->image : 'https://avatars.mds.yandex.net/get-mpic/1923922/img_id3485673576547289781.jpeg/6hq'; ?>" alt="">
            </div>
            <div class="element-title">
                <a href=""><?= Html::encode($product->name); ?></a>
            </div>
            <div class="element-price"><?= Html::encode($product->price); ?> ₽</div><br>

            <?= Html::beginForm(['product/update', 'id' => $product->id], 'PATCH'); ?>
                <?= Html::submitButton('Обновить', ['class' => 'btn']); ?>
            <?= Html::endForm(); ?><br>

            <?= Html::beginForm(['product/delete', 'id' => $product->id], 'delete'); ?>
                <?= Html::submitButton('Удалить', ['class' => 'btn', 'style' => 'background-color: red;']); ?>
            <?= Html::endForm(); ?>

        </div>
    </div>   
<?php endforeach; ?>