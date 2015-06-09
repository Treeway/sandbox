<?php

/*trade/detail*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<h1>订单状态</h1>
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
<h2>
<?php
    if( isset($warning)){
    print_r($warning);
}
?>
</h2>
<?php
    if( isset($rdeq)){
    print_r($req);
}
?>

<?php if(isset($req)) {?>
<table class="table table-hover table-striped" style="width: 800px;">
    <tbody>
        <tr>
            <th>交易编号</th>
            <th>创建时间</th>
            <th>收货人姓名</th>
            <th>实付金额</th>
            <th>订单状态</th>
        </tr>
        <?php foreach ($req->trades->trade as $item) {

        ?>
        <tr>
            <td><?php echo $item->tid; ?></td>
            <td><?php echo $item->created; ?></td>
            <td><?php echo $item->receiver_name; ?></td>
            <td><?php echo $item->payment; ?></td>
            <td><?php statusShow($item->status); ?></td>
            
            

        </tr>
        <?php } ?>
        
    </tbody>
</table>
<?php } ?>

<?php 
function statusShow($param) {
    switch ($param){
                case 'TRADE_NO_CREATE_PAY':echo '没有创建支付宝交易';
            break;
                case 'WAIT_BUYER_PAY':echo '卖家部分发货';
            break;
                case 'WAIT_SELLER_SEND_GOODS':echo '买家已付款';
            break;
                case 'WAIT_BUYER_CONFIRM_GOODS':echo '卖家已发货';
            break;
                case 'TRADE_BUYER_SIGNED':echo '买家已签收';
            break;
                case 'TRADE_FINISHED':echo '交易成功';
            break;
                case 'TRADE_CLOSED':echo '付款以后用户退款成功';
            break;
                case 'RADE_CLOSED_BY_TAOBAO':echo '卖家或买家主动关闭交易';
            break;
                case 'PAY_PENDING':echo '国际信用卡支付付款确认中';
            break;
                case 'WAIT_PRE_AUTH_CONFIRM':echo '0元购合约中';
            break;
        default :echo '状态未知';
    }
}
?>