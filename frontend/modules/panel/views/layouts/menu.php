<?php

use frontend\assets\AppAsset;
use kartik\nav\NavX;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Menu;

/* @var $this View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        
        <?php
            NavBar::begin([
                'brandLabel' => 'StoreHelper',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => '主页', 'url' => ['/site/index']],
                ['label' => '关于', 'url' => ['/site/about']],
                ['label' => '联系我们', 'url' => ['/site/contact']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
                
            } else {
                $menuItems[] = ['label' => Yii::$app->user->identity->username, 'active'=>true, 'items' => [
                        ['label' => '管理面板', 'url' => ['/panel/center/index']],
                        ['label' => '退出', 'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                       
                    ]];
            }
            echo NavX::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>        

             
        <div class="container">
        <?php
            NavBar::begin([
                'brandLabel' => '管理面板',
                'brandUrl' => ['/panel/center/index'],
                'options' => [
                 
                ],
            ]);
            echo NavX::widget([
                'options'=>['class' => 'navbar-nav'],
                'items' => [
                    ['label' => '账号管理', 'active'=>true, 
                        'items' => [
                            ['label' => '账号列表', 'url' => ['/panel/account/aclist']],
                            ['label' => '账号授权', 'url' => ['/panel/account/auth'],
                                'linkOptions' => ['target' => '_blank']],]],
                    ['label' => '商品管理', 'active'=>true, 
                        'items' => [
                            ['label' => '商品详情', 'url' => ['/panel/item/detail']],
                            ['label' => '商品同步上架', 'url' => ['/panel/item/sycsale']],
                            ['label' => '商品同步下架', 'url' => ['/panel/item/sycdown']],
                            
                    ]],
                    ['label' => '库存同步', 'active'=>true, 
                        'items' => [
                            ['label' => '商品关联', 'url' => ['/panel/item/attach']],
                            ['label' => '自动同步', 'url' => ['/panel/item/syc']],
                    ]],
                    
                    ['label' => '订单管理', 'active'=>true,
                        'items' => [
                            ['label' => '订单状态', 'url' => ['/panel/trade/detail']],
                            ['label' => '订单更新', 'url' => ['/panel/trade/modify']],
                            ]],
                    ['label' => '安全中心', 'active'=>true, 'url' => ['/panel/security/config']],
                ]
            ]);
          
//        echo Menu::widget([
//            'items' => [
//                // Important: you need to specify url as 'controller/action',
//                // not just as 'controller' even if default action is used.
//                ['label' => 'Home', 'url' => ['site/index']],
//                // 'Products' menu item will be selected as long as the route is 'product/index'
//                ['label' => 'Products', 'url' => ['product/index'], 'items' => [
//                    ['label' => 'New Arrivals', 'url' => ['product/index', 'tag' => 'new']],
//                    ['label' => 'Most Popular', 'url' => ['product/index', 'tag' => 'popular']],
//                ]],
//                ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
//            ],
//        ]);       


            NavBar::end();
        ?>
           
        <div>
        <?= $content ?>
        </div>
        </div>
        
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; StoreHelper <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
