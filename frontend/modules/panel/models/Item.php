<?php

namespace app\modules\panel\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "item".
 *
 * @property integer $id
 * @property string $num_iid
 * @property string $title
 * @property string $desc
 * @property string $price
 * @property string $num
 * @property string $outer_id
 * @property string $cid
 * @property string $tb_user_id
 * @property integer $remmember_me
 */
class Item extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }
    
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num_iid' => 'Num Iid',
            'title' => 'Title',
            'desc' => 'Desc',
            'price' => 'Price',
            'num' => 'Num',
            'outer_id' => 'Outer ID',
            'cid' => 'Cid',
            'tb_user_id' => 'Tb User ID',
            'remmember_me' => 'Remmember Me',
        ];
    }
    
    public function getItemList($outer_id) {
        return Item::find()->where(['outer_id' => $outer_id])->all();
    }
    
    public function getItemByOutIdAndUid($outer_id, $tb_user_id){
        return $this->findOne(['tb_user_id'=>$tb_user_id,'outer_id'=>$outer_id]);
    }
    
    public function getItemListByUid($tb_user_id) {
        return $this->find()->where(['tb_user_id' => $tb_user_id])->all();
    }
    public function getItemListByOutid($outid) {
        return $this->find()->where(['outer_id' => $outid])->all();
    }
    
    public function getItemByOutid($outid) {
        return $this->findOne(['outer_id' => $outid]);
    }
    
    
}
