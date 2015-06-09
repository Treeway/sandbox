<?php
/**
 * TOP API: taobao.tmc.message.produce request
 * 
 * @author auto create
 * @since 1.0, 2015.05.17
 */
class TmcMessageProduceRequest
{
	/** 
	 * 消息内容的JSON表述，必须按照topic的定义来填充
	 **/
	private $content;
	
	/** 
	 * 消息的扩增属性，用json格式表示
	 **/
	private $exContent;
	
	/** 
	 * 回传的文件内容，目前仅支持jpg,png,bmp,gif,pdf类型的文件，文件最大1M。只有消息中有byte[]类型的数据时，才需要传此字段; 否则不需要传此字段。
	 **/
	private $mediaContent;
	
	/** 
	 * 直发消息需要传入目标appkey
	 **/
	private $targetAppkey;
	
	/** 
	 * 消息类型
	 **/
	private $topic;
	
	private $apiParas = array();
	
	public function setContent($content)
	{
		$this->content = $content;
		$this->apiParas["content"] = $content;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setExContent($exContent)
	{
		$this->exContent = $exContent;
		$this->apiParas["ex_content"] = $exContent;
	}

	public function getExContent()
	{
		return $this->exContent;
	}

	public function setMediaContent($mediaContent)
	{
		$this->mediaContent = $mediaContent;
		$this->apiParas["media_content"] = $mediaContent;
	}

	public function getMediaContent()
	{
		return $this->mediaContent;
	}

	public function setTargetAppkey($targetAppkey)
	{
		$this->targetAppkey = $targetAppkey;
		$this->apiParas["target_appkey"] = $targetAppkey;
	}

	public function getTargetAppkey()
	{
		return $this->targetAppkey;
	}

	public function setTopic($topic)
	{
		$this->topic = $topic;
		$this->apiParas["topic"] = $topic;
	}

	public function getTopic()
	{
		return $this->topic;
	}

	public function getApiMethodName()
	{
		return "taobao.tmc.message.produce";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->content,"content");
		RequestCheckUtil::checkMaxLength($this->content,5000,"content");
		RequestCheckUtil::checkMaxLength($this->exContent,500,"exContent");
		RequestCheckUtil::checkMaxLength($this->targetAppkey,256,"targetAppkey");
		RequestCheckUtil::checkNotNull($this->topic,"topic");
		RequestCheckUtil::checkMaxLength($this->topic,256,"topic");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
