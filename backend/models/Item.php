<?php

namespace app\models;

use Yii;

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
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $remmember_me
 */
class Item extends \yii\db\ActiveRecord
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
            [['num_iid', 'title', 'desc', 'price', 'num', 'outer_id', 'cid', 'tb_user_id', 'created_at', 'updated_at', 'remmember_me'], 'required'],
            [['created_at', 'updated_at', 'remmember_me'], 'integer'],
            [['num_iid', 'title', 'desc', 'price', 'num', 'outer_id', 'cid', 'tb_user_id'], 'string', 'max' => 255]
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'remmember_me' => 'Remmember Me',
        ];
    }
}
