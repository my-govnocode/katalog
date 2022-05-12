<?php

namespace app\commands;

use app\models\GroupProperty;
use app\models\Property;
use yii\helpers\Console;
use yii\console\ExitCode;

class SeedController extends \yii\console\Controller
{
    public function actionIndex()
    {
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
                echo $this->ansiFormat('Заполнение прошло успешно', Console::FG_GREEN);
                return ExitCode::OK;
            } else {
                echo $this->ansiFormat('Свойства не создались', Console::FG_YELLOW);
            }
        } else {
            echo $this->ansiFormat('Группы не создались', Console::FG_YELLOW);
        }
    }
}
