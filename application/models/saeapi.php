<?php
class Saeapi extends CI_Model{
	public $access_token;
	public $user_id;
	public $api_url = 'https://api.weibo.com/2/';

	function __construct(){
		parent::__construct();
		$oauth2 = $this->session->userdata('oauth2');
		$this->access_token = $oauth2['oauth_token'];
		$this->user_id = $oauth2['user_id'];
	}

	function place_user_timeline($uid = NULL, $count = 20, $page = NULL)
	{
		/*
		 	必选	类型及范围	说明
		source	false	string	采用OAuth授权方式不需要此参数，其他授权方式为必填参数，数值为应用的AppKey。
		access_token	false	string	采用OAuth授权方式为必填参数，其他授权方式不需要此参数，OAuth授权后获得。
		uid	true	int64	需要查询的用户ID。
		since_id	false	int64	若指定此参数，则返回ID比since_id大的微博（即比since_id时间晚的微博），默认为0。
		max_id	false	int64	若指定此参数，则返回ID小于或等于max_id的微博，默认为0。
		count	false	int	单页返回的记录条数，最大为50，默认为20。
		page	false	int	返回结果的页码，默认为1。
		base_app	false	int	是否只获取当前应用的数据。0为否（所有数据），1为是（仅当前应用），默认为0。
		*/
	
		$getjson = $this->api_url . 'place/user_timeline.json?';
		if($uid != NULL) $getjson = $getjson .  '&uid=' . $uid;
		$getjson =$getjson .  '&count=' . $count;
		if($page != NULL) $getjson =$getjson .  '&page=' . $page;
		$getjson =$getjson .  '&access_token=' . $this->access_token;
		
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL,$getjson);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		$content = curl_exec($ch); 
		return $content;
	}

	function friendships_fridens($uid = NULL, $count = 50){
		/*
		 	必选	类型及范围	说明
		source	false	string	采用OAuth授权方式不需要此参数，其他授权方式为必填参数，数值为应用的AppKey。
		access_token	false	string	采用OAuth授权方式为必填参数，其他授权方式不需要此参数，OAuth授权后获得。
		uid	false	int64	需要查询的用户UID。
		screen_name	false	string	需要查询的用户昵称。
		count	false	int	单页返回的记录条数，默认为50，最大不超过200。
		cursor	false	int	返回结果的游标，下一页用返回值里的next_cursor，上一页用previous_cursor，默认为0。
		trim_status	false	int	返回值中user字段中的status字段开关，0：返回完整status字段、1：status字段仅返回status_id，默认为1。
		*/
		$getjson = $this->api_url . 'friendships/friends/ids.json?';
		if($uid != NULL) $getjson = $getjson .  '&uid=' . $uid;
	    $getjson = $getjson .  '&count=' . $count;
		$getjson =$getjson .  '&access_token=' . $this->access_token;
		
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL,$getjson);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		$content = curl_exec($ch); 
		return $content;
	}

	function users_show($uid = NULL){
		/*
	 				必选	类型及范围	说明
		source	false	string	采用OAuth授权方式不需要此参数，其他授权方式为必填参数，数值为应用的AppKey。
		access_token	false	string	采用OAuth授权方式为必填参数，其他授权方式不需要此参数，OAuth授权后获得。
		uid	false	int64	需要查询的用户ID。
		screen_name	false	string	需要查询的用户昵称。
		*/
		$getjson = $this->api_url . 'users/show.json?';
		if($uid != NULL) $getjson = $getjson .  '&uid=' . $uid;
		$getjson =$getjson .  '&access_token=' . $this->access_token;
		
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL,$getjson);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		$content = curl_exec($ch); 
		return $content;		
	}

	function place_nearby_timeline($lat = NULL, $long = NULL, $count = 50, $range = 2000, $sort = 0)
	{
	/*
		lat			true	float	Î³¶È¡£ÓÐÐ§·¶Î§£º-90.0µ½+90.0£¬+±íÊ¾±±Î³¡£
		long			true	float	¾­¶È¡£ÓÐÐ§·¶Î§£º-180.0µ½+180.0£¬+±íÊ¾¶«¾­¡£
		range		false	int	ËÑË÷·¶Î§£¬µ¥Î»Ã×£¬Ä¬ÈÏ2000Ã×£¬×î´ó11132Ã×¡£
		starttime	false	int	¿ªÊ¼Ê±¼ä£¬UnixÊ±¼ä´Á¡£
		endtime	false	int	½áÊøÊ±¼ä£¬UnixÊ±¼ä´Á¡£
		sort			false	int	ÅÅÐò·½Ê½¡£Ä¬ÈÏÎª0£¬°´Ê±¼äÅÅÐò£»Îª1Ê±°´ÓëÖÐÐÄµã¾àÀë½øÐÐÅÅÐò¡£
		count		false	int	µ¥Ò³·µ»ØµÄ¼ÇÂ¼ÌõÊý£¬×î´óÎª50£¬Ä¬ÈÏÎª20¡£
		page		false	int	·µ»Ø½á¹ûµÄÒ³Âë£¬Ä¬ÈÏÎª1¡£
		base_app	false	int	ÊÇ·ñÖ»»ñÈ¡µ±Ç°Ó¦ÓÃµÄÊý¾Ý¡£0Îª·ñ£¨ËùÓÐÊý¾Ý£©£¬1ÎªÊÇ£¨½öµ±Ç°Ó¦ÓÃ£©£¬Ä¬ÈÏÎª0¡£
		offset		false	int	´«ÈëµÄ¾­Î³¶ÈÊÇ·ñÊÇ¾ÀÆ«¹ý£¬0£ºÃ»¾ÀÆ«¡¢1£º¾ÀÆ«¹ý£¬Ä¬ÈÏÎª0¡£
	*/
	
		$getjson = $this->api_url . 'place/nearby_timeline.json?';
		if($lat != NULL) $getjson = $getjson .  '&lat=' . $lat;
		if($long != NULL) $getjson = $getjson .  '&long=' . $long;
		if($range != 2000) $getjson =$getjson .  '&range=' . $range;
		if($sort != 0) $getjson = $getjson .  '&sort=' . $sort;
		$getjson = $getjson .  '&count=' . $count;
		$getjson =$getjson .  '&access_token=' . $this->access_token;
		
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL,$getjson);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		$content = curl_exec($ch); 
		$return = json_decode($content, true);
		return $return;
	}
}
?>