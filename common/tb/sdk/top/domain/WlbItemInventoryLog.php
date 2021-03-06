<?php

/**
 * 库存变更记录
 * @author auto create
 */
class WlbItemInventoryLog
{
	
	/** 
	 * 批次号
	 **/
	public $batchCode;
	
	/** 
	 * 创建日期
	 **/
	public $gmtCreate;
	
	/** 
	 * 库存变更ID
	 **/
	public $id;
	
	/** 
	 * VENDIBLE  1-可销售;
FREEZE  201-冻结库存;
ONWAY  301-在途库存;
DEFECT  101-残存品;
ENGINE_DAMAGE 102-机损;
BOX_DAMAGE 103-箱损
	 **/
	public $inventType;
	
	/** 
	 * 商品ID
	 **/
	public $itemId;
	
	/** 
	 * 库存操作作类型
CHU_KU 1-出库
RU_KU 2-入库
FREEZE 3-冻结
THAW 4-解冻
CHECK_FREEZE 5-冻结确认
CHANGE_KU 6-库存类型变更
	 **/
	public $opType;
	
	/** 
	 * 库存操作者ID
	 **/
	public $opUserId;
	
	/** 
	 * 订单号
	 **/
	public $orderCode;
	
	/** 
	 * 订单商品ID
	 **/
	public $orderItemId;
	
	/** 
	 * 处理数量变化值
	 **/
	public $quantity;
	
	/** 
	 * 备注
	 **/
	public $remark;
	
	/** 
	 * 结果值
	 **/
	public $resultQuantity;
	
	/** 
	 * 仓库编码
	 **/
	public $storeCode;
	
	/** 
	 * 用户ID
	 **/
	public $userId;	
}
?>