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
<h1>自动同步</h1>

<p><a class="btn btn-lg btn-success" href="listen?op=permit">订阅消息</a>
    <a class="btn btn-lg btn-warning" href="listen?op=cancle">取消订阅</a>
</p>
<h3>
<?php isset($info)? printf($info): 0 ?>
<h3>