<?php

namespace app\models;

use Yii;

class RegisterForm extends \yii\base\Model
{
    public $username;
    public $email;
    public $password;
    public $password_confirm;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password_confirm'], 'required'],
            [['username', 'email', 'password', 'password_confirm'], 'string', 'max' => 255],
            [['email'], 'unique', 'targetClass' => User::class],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm password'
        ];
    }

    public function register()
    {
        $user = new User();
        $user->role = User::ROLE_USER;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        $user->save();
    }
}
