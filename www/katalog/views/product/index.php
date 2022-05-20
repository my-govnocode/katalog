<?php
use app\widgets\Categories;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?= Categories::widget(['url' => Url::toRoute('product/index')]); ?>
    <div class="column col-9">

    <?php
    $js = <<< JS
        $('#searchForm').on('submit', function(e){
        event.preventDefault();
        let form = $(this);
        let data = $(this).serialize();
    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: data,
        success: function(data){
        $('#products').html(data)
        },
        error: function(){
        alert('Ошибка!');
        }
    });
    return false;
    })
    JS;
    $this->registerJs($js);
    ?>

            <form class="col-md-12" id="searchForm" method="get" action="<?= Url::toRoute('product/index'); ?>">
                <div class="row d-flex justify-content-between">
                    <input name="search" type="text" class="col-md-10" placeholder="Искать здесь...">
                    <button type="submit" class="btn col-md-2" class="btn">Искать</button>
                </div>
            </form>
            <br>

            <?php if($session->hasFlash('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= $session->getFlash('success'); ?>
                </div>
            <?php elseif($session->hasFlash('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $session->getFlash('error'); ?>
                </div>
            <?php endif; ?>

        <div id="products" class="columns">
            <?= $this->render('products', ['products' => $products]); ?>
        </div>
    </div>
</div>