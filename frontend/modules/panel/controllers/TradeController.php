<?php

namespace app\modules\panel\controllers;

use app\modules\panel\models\Account;
use app\modules\panel\models\RadioAccFrom;
use common\tb\AppSetting;
use ItemsOnsaleGetRequest;
use TopClient;
use TradesSoldGetRequest;
use Yii;
use yii\web\Controller;

class TradeController extends Controller
{
    public function actionTrade()
    {
        
        return $this->render('trade');
    }
    
    public function actionDetail(){
          $model = new RadioAccFrom();
          $acc = new Account();
          $data = $acc->getAccList();
          $data =\yii\helpers\ArrayHelper::map($data, 'tb_user_id', 'tb_nick_name');
          $myreq = Yii::$app->request->post();
          if(!empty($myreq['RadioAccFrom']['acc_id'])){
               $sessionKey = $acc->getKeyByUserId($myreq['RadioAccFrom']['acc_id']);
              
               $c = new TopClient;
               $c->appkey = AppSetting::CLIENT_ID;
               $c->secretKey = AppSetting::CLIENT_SECRET;
               $req = new TradesSoldGetRequest;
               $req->setFields("seller_nick,buyer_nick,title,type,created,sid,tid,seller_rate,buyer_rate,status,payment,discount_fee,adjust_fee,post_fee,total_fee,pay_time,end_time,modified,consign_time,buyer_obtain_point_fee,point_fee,real_point_fee,received_payment,commission_fee,pic_path,num_iid,num_iid,num,price,cod_fee,cod_status,shipping_type,receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_zip,receiver_mobile,receiver_phone,orders.title,orders.pic_path,orders.price,orders.num,orders.iid,orders.num_iid,orders.sku_id,orders.refund_status,orders.status,orders.oid,orders.total_fee,orders.payment,orders.discount_fee,orders.adjust_fee,orders.sku_properties_name,orders.item_meal_name,orders.buyer_rate,orders.seller_rate,orders.outer_iid,orders.outer_sku_id,orders.refund_id,orders.seller_type");
               $resp = $c->execute($req, $sessionKey);
               
               if ($resp->total_results > 0){

                    return $this->render('detail',['model' => $model,
                          'data' => $data,
                          'req' => $resp,
                          'user' => $data[$myreq['RadioAccFrom']['acc_id']]
                          ]);
               }elseif ($resp->total_results == 0) {
                   return $this->render('detail', ['model' => $model,
                       'data' => $data,
                       'warning' => '暂无订单']);
            }  else {
                return $this->render('detail', ['model' => $model,
                        'data' => $data,
                        'warning' => '查询错误']);
            }
          }
          return $this->render('detail',['model' => $model, 'data' => $data]);
    }
    
    public function actionModify() {
        return $this->render('modify');
    }
    
}
