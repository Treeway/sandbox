<?php

/**
 * E客服账号操作记录
 * @author auto create
 */
class AccountStat
{
	
	/** 
	 * 登录状态。0：离线；1：在线
	 **/
	public $loginStatus;
	
	/** 
	 * 服务状态。0：挂起；1：服务
	 **/
	public $onserviceStatus;
	
	/** 
	 * 操作时间。格式：YYYY-mm-dd HH:MM:SS
	 **/
	public $time;	
}
?>