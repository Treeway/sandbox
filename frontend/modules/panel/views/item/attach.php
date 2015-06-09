<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<h1>商品关联</h1>
    <div>
        <div class="col-lg-5" style="width: 200px;">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'acc_id')->dropDownList($data)->label('账号名') ?>
                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        <h3><?php isset($user)?printf($user):null ?></h3>
    </div>

<?php if(isset($req)) {?>
<table class="table table-hover table-striped" style="width: 800px;">
    <tbody>
        <tr>
            <th>商品标题</th>
            <th>商品ID</th>
            <th>价格</th>
            <th>库存数量</th>
        </tr>
        <?php  foreach ($req->items->item as $item) {
            if (!isset($item->outer_id)){
        ?>
        <tr>
            <td>
                <a href="../item/setid?id=<?php echo $item->num_iid ?>&title=<?= urlencode( $item->title)?>&uid=<?php echo $uid ?>">
                <?php echo $item->title; ?><a>
            </td>
            <td><?php echo $item->num_iid; ?></td>
            <td><?php echo $item->price; ?></td>
            <td><?php echo $item->num; ?></td>
        </tr>

        <?php
            }
        
                        } ?>
        
    </tbody>
</table>
<?php } ?>

