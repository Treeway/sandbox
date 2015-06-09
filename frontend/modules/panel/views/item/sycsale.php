<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<h1>同步上架</h1>
<h3>
<?php
isset($acc)? print_r($acc):0;
?>
</h3>
    <div>
        <div class="col-lg-5" style="width: 500px;">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($check, 'acc_array')->checkboxList(
            ArrayHelper::map($data, 'tb_user_id', 'tb_nick_name'),
                        ['separator' => ' '])->label('账号名') ?>
            <?= $form->field($check, 'title')->label("商品标题") ?>
            <?= $form->field($check, 'desc')->label("描述") ?>
            <?= $form->field($check, 'price')->label("价格") ?>
            <?= $form->field($check, 'num')->label("数量") ?>
            <?= $form->field($check, 'outer_id')->label("自定义单号") ?>
                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        
    </div>