<?php

namespace app\controllers;

use yii\helpers\Url;
use app\models\User;
use app\models\LoginForm;
use app\models\RegisterForm;
use Yii;

class AuthController extends \yii\web\Controller
{
    public $layout = 'main';

    public function actionLogin()
    {
        $session = Yii::$app->session;
        $model = new LoginForm();

        if(Yii::$app->user->isGuest) {
            $data = Yii::$app->request->post();
            if($model->load($data) && $model->validate()) {
                $identity = User::findOne(['email' => $data['LoginForm']['email']]);
                if($identity && Yii::$app->getSecurity()->validatePassword($data['LoginForm']['password'], $identity['password'])) {
                    Yii::$app->user->login($identity);
                    return $this->redirect('/catalog');
                } else {
                    $session->setFlash('error', 'Неверный email или пароль.');
                    return $this->redirect(Url::toRoute('auth/login', ['model' => $model, 'session' => $session]));
                }
            }else{
                return $this->render('login', [
                    'model' => $model,
                    'session' => $session
                ]);
            }
        }else{
            return $this->redirect('/');
        }
    }

    public function actionRegister()
    {
        $model = new RegisterForm();
        $data = Yii::$app->request->post();
        if($model->load($data) && $model->validate()) {
            $model->register($data['RegisterForm']);
            return $this->redirect(Url::to('login'));
        }else{
            return $this->render('register', [
                'model' => $model
            ]);
        }
    }

    public function actionLogout()
    {
        if(Yii::$app->user->identity) {
            Yii::$app->user->logout();
            return $this->redirect(Url::toRoute('auth/login'));
        }else{
            return $this->redirect(Url::to('login'));
        }
    }
}
