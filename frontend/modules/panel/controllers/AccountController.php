<?php

namespace app\modules\panel\controllers;

use app\modules\panel\models\Account;
use app\modules\panel\models\search\AccountSearch;
use common\helper\TBCurl;
use common\tb\AppSetting;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
/**
 * AccountController implements the CRUD actions for Account model.
 */
class AccountController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Account models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Account model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Account model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Account();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Account model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        
        $model = $this->findModel($id);
        if(time()-$model['updated_at'] <=85000){
            
            $dst_url = AppSetting::ACCESS_URL;
            $post_arr = [
                'client_id' => AppSetting::CLIENT_ID,
                'client_secret' => AppSetting::CLIENT_SECRET,
                'grant_type' => 'refresh_token',
                'refresh_token' =>$model['refresh_token']];
            $curl = new TBCurl();
            $account_json = $curl->https_curl($dst_url,$post_arr);
            $account = json_decode($account_json, 1);    
            
            if(isset($account['access_token'])) {
                $show_info['uid'] = $account['taobao_user_id'];
                $show_info['nick'] = urldecode($account['taobao_user_nick']);
                $model->tb_user_id = $account['taobao_user_id'];
                $model->tb_nick_name = urldecode($account['taobao_user_nick']);
                $model->access_token = $account['access_token'];
                $model->refresh_token = $account['refresh_token'];
                $model->host_id = Yii::$app->user->identity->id;
                $model->remmenber_me = 1;
                $model->update();
                return $this->actionAclist();            
            }  else {
                return $this->render('auth');
            }
        }  else {
            return $this->render('auth');
        }
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Deletes an existing Account model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['aclist']);
    }

    /**
     * Finds the Account model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Account the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Account::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionAuth() {
        $url = AppSetting::REDIRECT_URL;
        $appid = AppSetting::CLIENT_ID;
        return $this->render('auth',['url' => $url, 'appid'=>$appid]);
    }
    
    public function actionConfirm() {      
        $model = new Account();
        $req = \Yii::$app->getRequest();
        if (isset($req->queryParams['code']) && $code = $req->queryParams['code']){               
            $dst_url = AppSetting::ACCESS_URL;
            $post_arr = [
                'code' => $code,
                'grant_type' => 'authorization_code',
                'client_id' => AppSetting::CLIENT_ID,
                'client_secret' => AppSetting::CLIENT_SECRET,
                'redirect_uri' => AppSetting::REDIRECT_URL];
            $curl = new TBCurl();
            $account_json = $curl->https_curl($dst_url,$post_arr);
            $account = json_decode($account_json, 1);
            
            if(isset($account['access_token'])) {
                $show_info['uid'] = $account['taobao_user_id'];
                $show_info['nick'] = urldecode($account['taobao_user_nick']);
                $model->tb_user_id = $account['taobao_user_id'];
                $model->tb_nick_name = urldecode($account['taobao_user_nick']);
                $model->access_token = $account['access_token'];
                $model->refresh_token = $account['refresh_token'];
                $model->host_id = Yii::$app->user->identity->id;
                $model->remmenber_me = 1;
                $model->validate();
                $model->save();
                    return $this->render('confirm', ['info' => $show_info]);             
            }  else {
                return $this->render('reauth');
            }
            
        }else {
            //return $this->render('confirm', ['info' => ['nick' => 'SB']]); 
            return $this->goHome();
        } 
    }
    
    public function actionAclist() {
        
        $id = Yii::$app->user->identity->id;
        $dataProvider = new ActiveDataProvider([
            'query' => Account::find()->where(['remmenber_me' => 1,'host_id' => $id]),
        ]);
        return $this->render('aclist', ['dataProvider' => $dataProvider]);     
    }
    
    public function actionTest() {
        $model = new Account();
        $data = $model->getAccList();
        return $this->render('test', ['test' => $data]);
    }
    
    public function actionReauth() {
        return $this->render('reauth');
    }
}
