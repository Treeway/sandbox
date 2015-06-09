<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\panel\models;
use yii\base\Model;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CheckboxForm extends Model{
    public $acc_array;
    public $tb_user_id;
    public $title;
    public $desc;
    public $price;
    public $num;
    public $outer_id;
    public $num_iid;


    public function rules() {
        return [];
    }
    
}