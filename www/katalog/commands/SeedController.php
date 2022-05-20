<?php

namespace app\commands;

use app\models\GroupProperty;
use app\models\Property;
use app\models\Product;
use yii\helpers\Console;
use yii\console\ExitCode;
use Faker\Factory;
use Yii;

class SeedController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $faker = Factory::create();
        
        $groupRazmer = new GroupProperty();
        $groupRazmer->name = 'Размер';
        $groupRazmer->code = 'razmer';

        $groupTkan = new GroupProperty();
        $groupTkan->name = 'Ткань';
        $groupTkan->code = 'tkan';

        if ($groupRazmer->save() && $groupTkan->save()) {
            $propertyBig = new Property();
            $propertyBig->name = 'Большая';
            $propertyBig->code = 'big';
            $propertyBig->group_id = $groupRazmer->id;

            $propertySmall = new Property();
            $propertySmall->name = 'Маленькая';
            $propertySmall->code = 'small';
            $propertySmall->group_id = $groupRazmer->id;

            $propertyBad = new Property();
            $propertyBad->name = 'Плохая';
            $propertyBad->code = 'bad';
            $propertyBad->group_id = $groupTkan->id;

            $propertyGood = new Property();
            $propertyGood->name = 'Хорошая';
            $propertyGood->code = 'good';
            $propertyGood->group_id = $groupTkan->id;

            if ($propertyBad->save() &&  $propertyGood->save() && $propertyBig->save() && $propertySmall->save()) {
                $products = [];

                for ($i=0;$i<10;$i++) {
                    $products[] = [
                        $faker->name,
                        $faker->randomFloat(2, Product::PRICE_MIN, Product::PRICE_MAX)
                    ];
                }

                $productsCreate = Yii::$app->db->createCommand()->batchInsert('products', ['name', 'price'], $products)->execute();

                if ($productsCreate != 0) {

                $productsFirst10 = Product::find()->orderBy(['id' => SORT_ASC])->limit(10)->all();
                $properties = [[$propertyBig, $propertySmall], [$propertyBad, $propertyGood]];
                $arr = [];

                foreach ($productsFirst10 as $product) {
                    for ($i=0;$i<2;$i++) {
                        $property = $properties[$i][rand(0, 1)];
                        $arr[] = [
                            $property->id,
                            $product->id,
                            $property->group_id
                        ];
                    }
                }

                $PropertyProduct = Yii::$app->db->createCommand()->batchInsert('property_product', ['property_id', 'product_id', 'group_id'], $arr)->execute();
                    if ($PropertyProduct != 0) {
                        echo $this->ansiFormat('Заполнение прошло успешно', Console::FG_GREEN);
                        return ExitCode::OK;
                    } else {
                        echo $this->ansiFormat('Связи не создались', Console::FG_YELLOW);
                    }
                } else {
                    echo $this->ansiFormat('Продукты не создались', Console::FG_YELLOW);
                }

            } else {
                echo $this->ansiFormat('Свойства не создались', Console::FG_YELLOW);
            }
        } else {
            echo $this->ansiFormat('Группы не создались', Console::FG_YELLOW);
        }
    }
}
