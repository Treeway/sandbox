<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\panel\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tb_account')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'tb_pwd')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'tb_user_id')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'tb_nick_name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'access_token')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'refresh_token')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'host_id')->textInput() ?>

    <?= $form->field($model, 'remmenber_me')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
