<!-- filter -->
<div class="filter">
    <?php foreach($groups as $group): ?>
        <!-- filter-item -->
        <div class="filter-item">
            <div class="filter-title"><?= $group->name ?></div>
            <div class="filter-content">
                <ul class="filter-list">
                    <?php foreach($group->propertys as $property): ?>
                        <li>
                            <input type="checkbox" id="filter-size-1">
                            <label for="filter-size-1"><?= $property->name ?></label>
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
                    <input type="text" class="price-input ui-slider-min" value="0">
                    <span class="price-sep"></span>
                    <input type="text" class="price-input ui-slider-max" value="2000">
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
                <button class="btn">Сбросить фильтр</button>
            </div>
        </div>
    </div>
</div>