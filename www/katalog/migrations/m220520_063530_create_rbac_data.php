<?php

use yii\db\Migration;
use app\models\User;

/**
 * Class m220520_063530_create_rbac_data
 */
class m220520_063530_create_rbac_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->runAction('migrate', [
            'migrationPath' => '@yii/rbac/migrations',
        ]);

        $auth = Yii::$app->authManager;
        $roleUser = $auth->createRole(User::ROLE_USER);
        $auth->add($roleUser);

        $auth = Yii::$app->authManager;
        $roleAdmin = $auth->createRole(User::ROLE_ADMIN);
        $auth->add($roleAdmin);
        $auth->addChild($roleAdmin, $roleUser);

        $admin = new User();
        $admin->username = "admin";
        $admin->email = "admin@mail.ru";
        $admin->password = Yii::$app->getSecurity()->generatePasswordHash('12345678');
        $admin->role = User::ROLE_ADMIN;
        $admin->save();

        $auth->assign($roleAdmin, $admin->id);
    }

    public function safeDown()
    {
    }
}
