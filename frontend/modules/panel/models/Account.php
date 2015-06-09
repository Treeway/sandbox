<?php

namespace app\modules\panel\models;

use common\helper\TBCurl;
use common\tb\AppSetting;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "account".
 *
 * @property integer $id
 * @property string $tb_account
 * @property string $tb_pwd
 * @property string $tb_user_id
 * @property string $tb_nick_name
 * @property string $access_token
 * @property string $refresh_token
 * @property integer $host_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $remmenber_me
 */
class Account extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account';
    }

    
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tb_user_id', 'access_token', 'refresh_token', 'host_id'], 'required'],
            ['host_id', 'integer'],
            [['tb_account', 'tb_user_id', 'tb_nick_name', 'access_token', 'refresh_token'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tb_account' => 'Tb Account',
            'tb_pwd' => 'Tb Pwd',
            'tb_user_id' => '淘宝ID',
            'tb_nick_name' => '账号昵称',
            'access_token' => 'Access Token',
            'refresh_token' => 'Refresh Token',
            'host_id' => 'Host ID',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'remmenber_me' => 'Remmenber Me',
        ];
    }
    
    public function getAccList() {
        $id = Yii::$app->user->identity->id;
        return $this->find()->where(['host_id' => $id, 'remmenber_me' => 1])->all();
    }
    
    public function refreshKey() {
        if (time() - ($this->updated_at) < 8000){
            $dst_url = AppSetting::ACCESS_URL;
            $post_arr = [
                'code' => $code,
                'grant_type' => 'authorization_code',
                'client_id' => AppSetting::CLIENT_ID,
                'client_secret' => AppSetting::CLIENT_SECRET,
                'redirect_uri' => AppSetting::REDIRECT_URL];
            $curl = new TBCurl();
            $account_json = $curl->https_curl($dst_url,$post_arr);
            $account = json_decode($account_json, 1);
        }
    }
    
    public function findByUserId($tb_user_id){
        return $this->findOne(['tb_user_id' => $tb_user_id]);
    }
    
    public function getKeyByUserId($tb_user_id){
        return $this->findOne(['tb_user_id' => $tb_user_id])->access_token;
    }
}
