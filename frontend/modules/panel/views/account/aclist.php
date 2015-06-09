<?php

use yii\grid\GridView;
use yii\helpers\Html;
?>
<h1>授权账号列表</h1>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'tb_nick_name',
            'content' => function($dataProvider){
                return urldecode($dataProvider['tb_nick_name']);
            },
            
        ],
        'tb_user_id',
        [
            'attribute' => 'created_at',
            'format' =>  ['date', 'php:Y-m-d H:i:s'],
        ],
        [
            'attribute' => 'updated_at',
            'format' =>  ['date', 'php:Y-m-d H:i:s'],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{update}{delete}',
            'headerOptions' => ['width' => '128', 'class' => 'padding-left-5px',],
            'contentOptions' => ['class' => 'padding-left-5px'],
            'buttons' => [
                'password' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                        'title' => '修改密码',
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
                },
            ],
        ],
    ],
]); ?>