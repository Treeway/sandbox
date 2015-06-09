<?php
namespace common\helper;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class TBCurl{
    
    
    public function https_curl($url, $post_arr = array(), $timeout = 10) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $postBodyString = "";
        foreach ($post_arr as $k => $v){
        if("@" != substr($v, 0, 1))//判断是不是文件上传
        {
            $postBodyString .= "$k=" . urlencode($v) . "&"; 
        }
    }
	$header = array("content-type: application/x-www-form-urlencoded; charset=UTF-8");
	curl_setopt($curl,CURLOPT_HTTPHEADER,$header);    
	curl_setopt($curl, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
	$content = curl_exec($curl);
	curl_close($curl);

	return $content;        
    }
}
