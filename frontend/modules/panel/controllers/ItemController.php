<?php
namespace app\modules\panel\controllers;

use app\modules\panel\models\Account;
use app\modules\panel\models\CheckboxForm;
use app\modules\panel\models\Item;
use app\modules\panel\models\RadioAccFrom;
use common\tb\AppSetting;
use ItemAddRequest;
use ItemGetRequest;
use ItemsOnsaleGetRequest;
use ItemUpdateDelistingRequest;
use ItemUpdateRequest;
use TmcUserCancelRequest;
use TmcUserPermitRequest;
use TopClient;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;

class ItemController extends Controller
{
    public function actionItem()
    {
        return $this->render('item');
    }

    public function actionDetail() {
          $model = new RadioAccFrom();
          $acc = new Account();
          $data = $acc->getAccList();
          $data =ArrayHelper::map($data, 'tb_user_id', 'tb_nick_name');
          $myreq = Yii::$app->request->post();
          if(!empty($myreq['RadioAccFrom']['acc_id'])){
              $sessionKey = $acc->getKeyByUserId($myreq['RadioAccFrom']['acc_id']);
              $c = new TopClient;
              $c->appkey = AppSetting::CLIENT_ID;
              $c->secretKey = AppSetting::CLIENT_SECRET;
              $req = new ItemsOnsaleGetRequest;
              $req->setFields("approve_status,num_iid,title,nick,type,cid,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase,modified,delist_time,postage_id,seller_cids,outer_id");
              $resp = $c->execute($req, $sessionKey);
              return $this->render('detail',['model' => $model,
                    'data' => $data,
                    'req' => $resp, 
                    'uid' => $myreq['RadioAccFrom']['acc_id'],
                    'user'=> $data[$myreq['RadioAccFrom']['acc_id']]
                  ]);
          }
          return $this->render('detail',['model' => $model, 'data' => $data,]);
    }
    
    public function actionSyc() {
        return $this->render('syc');
    }
    
    public function actionOnsale()
    {
        $model = new Item();
        $data = Yii::$app->request->post();
        if(isset($data['Item']['tb_user_id'])){
            $acc = Account::findOne(['tb_user_id' => $data['Item']['tb_user_id']]);
            $sessionKey = $acc['access_token'];
            $c = new TopClient;
            $c->appkey = AppSetting::CLIENT_ID;
            $c->secretKey = AppSetting::CLIENT_SECRET;
            $req = new ItemAddRequest;
            $req->setNum(intval($data['Item']['num']));
            $req->setPrice($data['Item']['price']);
            $req->setType("fixed");
            $req->setStuffStatus("new");
            $req->setTitle($data['Item']['title']);
            $req->setDesc($data['Item']['desc']);
            $req->setLocationState("浙江");
            $req->setLocationCity("杭州");
            $req->setCid(50012906);
            $req->setProps("20000:3506324;20549:670;20549:671;20549:29542;122216351:30233;20490:28102;122216640:3323086;122216587:6474787;");
            $req->setOuterId($data['Item']['outer_id']);
            $resp = $c->execute($req, $sessionKey);
            if(isset($resp->item->num_iid)){
                $model->num_iid = $resp->item->num_iid;
                $model->title = $data['Item']['title'];
                $model->desc = $data['Item']['desc'];
                $model->price = $data['Item']['price'];
                $model->num = $data['Item']['num'];
                $model->outer_id = $data['Item']['outer_id'];
                $model->cid = 50012906;
                $model->tb_user_id = $data['Item']['tb_user_id'];
                $model->remmember_me = 1;
                $model->save();
            }
            $model = new Item();
            return $this->render('onsale', ['model' => $model, 'resp' => $resp]);
            
        }
        
        return $this->render('onsale', ['model' => $model, ]);

      
    }
    
    public function actionsDownsale() {
        return $this->render('downsale');
    }
    
    public function actionSycsale() {
        $check = new CheckboxForm();
        $acc = new Account();
        $data = $acc->getAccList();
        $map_acc = ArrayHelper::map($data, 'tb_user_id', 'access_token');
        $list = Yii::$app->request->post();
        $tb_list = null;
        if (isset($list['CheckboxForm']['acc_array'])) {
            
            $tb_list = $list['CheckboxForm']['acc_array'];
            
        }
        if ((!empty($tb_list)) && is_array($tb_list)){

            foreach ($tb_list as $value) {
                
                $sessionKey = $map_acc[$value];
                $c = new TopClient;
                $c->appkey = AppSetting::CLIENT_ID;
                $c->secretKey = AppSetting::CLIENT_SECRET;
                $req = new ItemAddRequest;
                $req->setNum(intval($list['CheckboxForm']['num']));
                $req->setPrice($list['CheckboxForm']['price']);
                $req->setType("fixed");
                $req->setStuffStatus("new");
                $req->setTitle($list['CheckboxForm']['title']);
                $req->setDesc($list['CheckboxForm']['desc']);
                $req->setLocationState("浙江");
                $req->setLocationCity("杭州");
                $req->setCid(50012027);
                //$req->setProps("20000:3506324;20549:670;20549:671;20549:29542;122216351:30233;20490:28102;122216640:3323086;122216587:6474787;");
                $req->setOuterId($list['CheckboxForm']['outer_id']);
                $resp = $c->execute($req, $sessionKey);
                if(isset($resp->item->num_iid)){
                    
                    $model = new Item();
                    $model->num_iid = $resp->item->num_iid;
                    $model->title = $list['CheckboxForm']['title'];
                    $model->desc = $list['CheckboxForm']['desc'];
                    $model->price = $list['CheckboxForm']['price'];
                    $model->num = $list['CheckboxForm']['num'];
                    $model->outer_id = $list['CheckboxForm']['outer_id'];
                    $model->cid = 50012906;
                    $model->tb_user_id = $value;
                    $model->remmember_me = 1;
                    $model->save();
                }  else {
                    return $this->render('sycsale', ['check' => $check,
                                'data' => $data,
                                'acc'=>'上架失败']);
                }
            }
            return $this->render('sycsale', ['check' => $check,
                        'data' => $data,
                        'acc'=>'成功上架']);
        }
        return $this->render('sycsale', ['check' => $check,
            'data' => $data,]);
    }
    
    public function actionSycdown() {
        $check = new CheckboxForm();
        $acc = new Account();
        $item = new Item();
        $data = $acc->getAccList();
        foreach ($data as $value) {
            $items = $item->getItemListByUid($value['tb_user_id']);
            foreach ($items as $value) {
                $item_list[] = $value;
            }
        }
        $map_acc = ArrayHelper::map($data, 'tb_user_id', 'access_token');
        $list = Yii::$app->request->post();
        $tb_list = null;
        
        if (isset($list['CheckboxForm']['acc_array'])) {
            
            $tb_list = $list['CheckboxForm']['acc_array'];
            
        }
        if ((!empty($tb_list)) && is_array($tb_list)){
            
            $FLAG = FALSE;
            foreach ($tb_list as $v){
                $num_iid = $item->getItemByOutIdAndUid($list['CheckboxForm']['outer_id'], $v);
                if(!$num_iid) {  continue; }
                $sessionKey = $map_acc[$v];
                $c = new TopClient;
                $c->appkey = AppSetting::CLIENT_ID;
                $c->secretKey = AppSetting::CLIENT_SECRET;
                $req = new ItemUpdateDelistingRequest;
                $req->setNumIid($num_iid['num_iid']);
                $resp = $c->execute($req, $sessionKey);
                if(isset($resp->item->num_iid)){
                    Item::findOne(['num_iid' => $resp->item->num_iid, 'tb_user_id' => $v])->delete();
                    $FLAG = TRUE;
                    
                }  else {
                return  $this->render('sycdown', ['check' => $check,
                            'data' => $data,
                            'item_list' => $item_list,
                            'acc' => '下架失败']);
                }
                
                return $this->render('sycdown', ['check' => $check,
                        'data' => $data,
                        'item_list' => $item_list,
                        'acc' => '下架成功']);
                
            }
        }
        
        
        return $this->render('sycdown', ['check' => $check,
            'data' => $data,
            'item_list' => $item_list,
                        ]);
    }
    
    
    public function actionShow($id) {
        $item = Item::findOne($id);
        echo Json::encode($item);
    }
    
    public function actionModify() {
        $model = new CheckboxForm();
        $data = \Yii::$app->getRequest()->getQueryParam('id');
        $model->num_iid = $data;        
        $outid = \Yii::$app->getRequest()->getQueryParam('outid');
        $model->outer_id = $outid;
        $uid = \Yii::$app->getRequest()->getQueryParam('uid');
        
        if ($li = Yii::$app->request->post()){
            $list = $li['CheckboxForm'];
            $list = array_filter($list);
            if (!empty($list)){
                    $c = new TopClient;
                    $c->appkey = AppSetting::CLIENT_ID;
                    $c->secretKey = AppSetting::CLIENT_SECRET;
                    $req = new ItemUpdateRequest;
                    $acc = new Account();
                    isset($list['num'])? $req->setNum($list['num']) : 0;
                    isset($list['price'])? $req->setPrice($list['price']) : 0;
                    isset($list['title'])? $req->setTitle($list['title']) : 0;
                    isset($list['desc'])? $req->setDesc($list['desc']) : 0;
                if ($outid == 0){
                    $req->setNumIid($data);
                    $sessionKey = $acc->getKeyByUserId($uid);
                    $resp = $c->execute($req, $sessionKey);
                    if(isset($resp->item->modified)){
                        return $this->render('makesure', ['info' => '修改成功']);
                    }else{
                        return $this->render('modify',['check' => $model,
                                'info' => '修改失败']);
                    }   
                }  else {
                    $item = new Item();
                    $items = $item->getItemListByOutid($outid);
                    if($items){
                        if(count($items) == 1){
                            $req->setNumIid($data);
                            $sessionKey = $acc->getKeyByUserId($uid);
                            $resp = $c->execute($req, $sessionKey);
                            if(isset($resp->item->modified)){
                                return $this->render('modify',['check' => $model,
                                        'info' => '修改成功']);
                            }else{
                                return $this->render('modify',['check' => $model,
                                        'info' => '修改失败']);
                            }                               
                        }  else {
                            $cur_user = new Account();
                            foreach ($items as $value){
                                $req->setNumIid($value['num_iid']);
                                $sessionKey = $cur_user->getKeyByUserId($value['tb_user_id']);
                                $resp = $c->execute($req, $sessionKey);
                               if(isset($resp->item->modified)){
                                   return $this->render('modify',['check' => $model,
                                            'info' => '修改成功']);
                               }else{
                                   return $this->render('modify',['check' => $model,
                                           'info' => '修改失败']);
                               }                               
                               
                            }
                            
                        }
                    }
                }

            }
        }
        
        return $this->render('modify',['check' => $model]);
    }
    
    
    public function modifyReq($acc,$uid, $req, $model) {
        $sessionKey = $acc->getKeyByUserId($uid);
        $resp = $c->execute($req, $sessionKey);
        if(isset($resp->item->modified)){
            return $this->render('makesure', ['info' => '修改成功']);
        }else{
            return $this->render('modify',['check' => $model,
                    'info' => '修改失败']);
            }
    }
    
    public function actionAttach(){
        $model = new RadioAccFrom();
        $acc = new Account();
        $data = $acc->getAccList();
        $data =ArrayHelper::map($data, 'tb_user_id', 'tb_nick_name');
        $myreq = Yii::$app->request->post();
        if(!empty($myreq['RadioAccFrom']['acc_id'])){
            $sessionKey = $acc->getKeyByUserId($myreq['RadioAccFrom']['acc_id']);
            $c = new TopClient;
            $c->appkey = AppSetting::CLIENT_ID;
            $c->secretKey = AppSetting::CLIENT_SECRET;
            $req = new ItemsOnsaleGetRequest;
            $req->setFields("approve_status,num_iid,title,nick,type,cid,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase,modified,delist_time,postage_id,seller_cids,outer_id");
            $resp = $c->execute($req, $sessionKey);

            return $this->render('attach',['model' => $model,
                  'data' => $data,
                  'req' => $resp, 
                  'uid' => $myreq['RadioAccFrom']['acc_id'],
                  'user'=> $data[$myreq['RadioAccFrom']['acc_id']]
                  
                ]);
        }
        return $this->render('attach',['model' => $model, 'data' => $data,]);
    }
    
    public function actionSetid() {
        $model = new CheckboxForm();
        $numiid = \Yii::$app->getRequest()->getQueryParam('id');      
        $uid = \Yii::$app->getRequest()->getQueryParam('uid');
        $title = \Yii::$app->getRequest()->getQueryParam('title');
        $title = urldecode($title);
        $model->title = $title;
        $model->num_iid = $numiid;
        
        $acc = new Account();
        $item = new Item();
        $data = $acc->getAccList();
        foreach ($data as $value) {
            if($value['tb_user_id'] == $uid)                
                continue;
            $item_list = $item->getItemListByUid($value['tb_user_id']);
            foreach ($item_list as $value){
                $idlist[$value['outer_id']] = $value['outer_id'];
            }
        }
        
        if($myreq = Yii::$app->request->post()){
            $li = array_filter($myreq['CheckboxForm']);
            if (!empty($li)){
                $c = new TopClient;
                $c->appkey = AppSetting::CLIENT_ID;
                $c->secretKey = AppSetting::CLIENT_SECRET;
                $req = new ItemUpdateRequest;
                $acc = new Account();
                if(!empty($li['outer_id'])){
                    
                    $sessionKey = $acc->getKeyByUserId($uid);
                    $req->setNumIid($numiid);
                    $req->setOuterId($li['outer_id']);
                    $resp = $c->execute($req, $sessionKey);
                    if(isset($resp->item->modified)){
                        $new_item = new Item();
                        $new_item->num_iid = $numiid;
                        $new_item->outer_id = $li['outer_id'];
                        $new_item->tb_user_id = $uid;
                        $new_item->save();
                        return $this->render('setid',['check' => $model,
                                'idlist' => $idlist,
                                'info' => '修改成功'    ]);
                    }else{
                        return $this->render('setid',['check' => $model,
                                'idlist' => $idlist,
                                'info' => '修改失败'    ]);
                    }  

                }
                if(empty($li['outer_id']) && isset($li['acc_array'])){
                    $syc_item = $item->getItemByOutid($li['acc_array']);
                    $syc_id = $syc_item['num_iid'];
                    $syc_sessionKey = $acc->getKeyByUserId($syc_item['tb_user_id']);                    
                    
                    $syc_req = new ItemGetRequest;
                    $syc_req->setFields("detail_url,num_iid,title,nick,type,cid,seller_cids,props,input_pids,input_str,desc,pic_url,num,valid_thru,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,has_invoice,has_warranty,has_showcase,modified,increment,approve_status,postage_id,product_id,auction_point,property_alias,item_img,prop_img,sku,video,outer_id,is_virtual");
                    $syc_req->setNumIid($syc_id);
                    $syc_resp = $c->execute($syc_req, $syc_sessionKey);
                   
                    if(isset($syc_resp->item->num_iid)){
                        $sessionKey = $acc->getKeyByUserId($uid);
                        $req->setNumIid($numiid);
                        $req->setOuterId($li['acc_array']);
                        $req->setNum($syc_resp->item->num);
                        $req->setPrice($syc_resp->item->price);
                        $req->setTitle($syc_resp->item->title);
                        $req->setDesc($syc_resp->item->desc);
                        $resp = $c->execute($req, $sessionKey);
                        if (isset($resp->item->modified)){
                            $new_item = new Item();
                            $new_item->num_iid = $numiid;
                            $new_item->outer_id = $li['acc_array'];
                            $new_item->tb_user_id = $uid;
                            $new_item->save();
                            return $this->render('setid',['check' => $model,
                                    'idlist' => $idlist,
                                    'info' => '修改成功'    ]);
                        } else {
                            return $this->render('setid',['check' => $model,
                                    'idlist' => $idlist,
                                    'info' => '修改失败'    ]);
                        }
                    }
                    
                }
                
            }
        }
        
        
        return $this->render('setid',['check' => $model,
            'idlist' => $idlist
                            ]);
    }
    
    public function actionListen() {
 
        $op = \Yii::$app->getRequest()->getQueryParam('op');
        $c = new TopClient;
        $c->appkey = AppSetting::CLIENT_ID;
        $c->secretKey = AppSetting::CLIENT_SECRET;
        $account = new Account();
        $acclist = $account->getAccList();
        if($op === 'permit'){
            foreach ($acclist as $value){
                $sessionKey = $value['access_token'];
                $req = new TmcUserPermitRequest;
                $resp = $c->execute($req, $sessionKey);
            }
            
            return $this->render('syc', ['info' =>'订阅成功',]);
        }
        if($op === 'cancle'){
            foreach ($acclist as $value){
                $req = new TmcUserCancelRequest;
                $req->setNick($value['tb_user_nick']);
                $resp = $c->execute($req);
            }
             return $this->render('syc', ['info' =>'取消成功',]);
        }
        return $this->render('syc');

    }
}