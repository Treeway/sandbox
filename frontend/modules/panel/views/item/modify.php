<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<h3>
    <?php isset($info)? print_r($info): null; ?>
</h3>
<h1>商品修改</h1>


    <div>
        <div class="col-lg-5" style="width: 500px;">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($check, 'num_iid')->label("商品ID")->textInput(['Disabled' => true]) ?>
            <?= $form->field($check, 'title')->label("商品标题") ?>
            <?= $form->field($check, 'desc')->label("描述") ?>
            <?= $form->field($check, 'price')->label("价格") ?>
            <?= $form->field($check, 'num')->label("数量") ?>
            <?= $form->field($check, 'outer_id')->label("外部编码")->textInput(['Disabled' => true]) ?>
                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        
    </div>
