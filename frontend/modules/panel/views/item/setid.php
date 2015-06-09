<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<h3>
    <?php isset($info)? print_r($info): null; ?>
</h3>
<h1>绑定外部编码</h1>


    <div>
        <div class="col-lg-5" style="width: 500px;">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($check, 'num_iid')->label("商品ID")->textInput(['Disabled' => true]) ?>
            <?= $form->field($check, 'title')->label("商品标题")->textInput(['Disabled' => true])  ?>
            <?= $form->field($check, 'acc_array')->dropDownList(
            $idlist,['prompt' => '选择账号'])->label('选择已有外部编号') ?>
            <?= $form->field($check, 'outer_id')->label("（或者）添加新的外部编号") ?>
                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        
    </div>