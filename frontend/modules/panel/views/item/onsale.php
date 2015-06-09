<?php

use app\modules\panel\models\Item;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Item */
/* @var $form ActiveForm */

isset($data)? var_dump($data): 0;
echo "<br>";
if(isset($resp)){
    echo "<h3>添加成功<h3>";
    echo "商品ID： ".$resp->item->num_iid;
    
}
?>
<div class="onsale" style="width: 500px;">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'tb_user_id')->label("发布店铺") ?>
        <?= $form->field($model, 'title')->label("商品标题") ?>
        <?= $form->field($model, 'desc')->label("描述") ?>
        <?= $form->field($model, 'price')->label("价格") ?>
        <?= $form->field($model, 'num')->label("数量") ?>
        <?= $form->field($model, 'outer_id')->label("自定义单号") ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- onsale -->
