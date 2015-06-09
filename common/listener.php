<?php

use common\tb\AppSetting;



/* 
handle msg from TB
 */

require(__DIR__ .'/tb/sdk/TopSdk.php');
require(__DIR__ .'/tb/AppSetting.php');

/**/
function toArray($msg) {
    $msg_array['id'] = $msg->id;
    $msg_array['pub_app_key'] = $msg->pub_app_key;
    $msg_array['pub_time'] = $msg->pub_time;
    $msg_array['topic'] = $msg->topic;
    $msg_array['user_id'] = $msg->user_id;
    $msg_array['user_nick'] = $msg->user_nick;
    $msg_array['content'] = $msg->content;
    return json_encode($msg_array);
}

function dealMsg($msg) {
    $tmc_msg = $msg->tmc_message;
    $msg_arr = toArray($tmc_msg);
    switch ($tmc_msg->topic){
        case 'taobao_trade_TradeCreate':
            
            break;
            case 'taobao_item_ItemAdd':
                break;
                case 'taobao_item_ItemDownshelf':
                    break;
                    case 'taobao_item_ItemUpdate':
                        break;
                    case 'taobao_item_ItemStockChanged':
                        break;
                        case 'taobao_fuwu_OrderPaid':
                            break;
                        default :
                            
    }
    file_put_contents('./recorder.html', date('Y-m-d H:i:s').$msg_arr."  ", FILE_APPEND);
}

$client = new TopClient;
$client->appkey = AppSetting::CLIENT_ID;
$client->secretKey = AppSetting::CLIENT_SECRET;

do{
    $msg_resp = null;
    do{
        $msg_req = new TmcMessagesConsumeRequest;
        $msg_resp = $client->execute($msg_req);
        var_dump($msg_resp);
        echo "<br>";
        if(isset($msg_resp->messages)){
            foreach ($msg_req->messages as $value) {
                dealMsg($value);
                $retMsg = new TmcMessagesConfirmRequest;
                $retMsg->setSMessageIds($value->tmc_message->id);
                $confirmRsep = $c->execute($retMsg);
                echo 'receive! ';
            }
        }
    }while (isset($msg_resp->messages));
    sleep(3);
}while (TRUE);




