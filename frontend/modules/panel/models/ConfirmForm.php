<?php


namespace frontend\modules\panel\models;

use yii\base\Model;


/**
 * Signup form
 */
class ConfirmForm extends Model
{
    
    public $tb_account;
    public $tb_pwd;
    public $tb_user_id;
    public $tb_nick_name;
    public $access_token;
    public $refresh_token;
    public $host_id;
    public $remmenber_me;
        /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tb_account', 'tb_pwd', 'tb_user_id', 'access_token', 'refresh_token', 'host_id',], 'required'],
            [['host_id', 'remmenber_me'], 'integer'],
            [['tb_account', 'tb_pwd', 'tb_user_id', 'tb_nick_name', 'access_token', 'refresh_token'], 'string', 'max' => 255]
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function add_account()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
