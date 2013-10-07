<?php
class Saeapi extends CI_Model{
	public $access_token;
	public $user_id;
	public $api_url = 'https://api.weibo.com/2/';

	function __construct(){
		parent::__construct();
	}

	function init(){
		$oauth2 = $this->session->userdata('oauth2');
		if($oauth2 != FALSE){
			$this->access_token = $oauth2['oauth_token'];
			$this->user_id = $oauth2['user_id'];
		}
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
		$this->init();
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

	function friendships_fridens($uid = NULL, $count = 50, $cursor = NULL){
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

		$this->init();		
		$getjson = $this->api_url . 'friendships/friends.json?';
		if($uid != NULL) $getjson = $getjson .  '&uid=' . $uid;
	    $getjson = $getjson .  '&count=' . $count;
		if($cursor != NULL) $getjson = $getjson .  '&cursor=' . $cursor;
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

		$this->init();		
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

	function place_nearby_timeline($lat = NULL, $long = NULL)
	{
	/*
	source	false	string	采用OAuth授权方式不需要此参数，其他授权方式为必填参数，数值为应用的AppKey。
	access_token	false	string	采用OAuth授权方式为必填参数，其他授权方式不需要此参数，OAuth授权后获得。
	lat	true	float	纬度。有效范围：-90.0到+90.0，+表示北纬。
	long	true	float	经度。有效范围：-180.0到+180.0，+表示东经。
	range	false	int	搜索范围，单位米，默认2000米，最大11132米。
	starttime	false	int	开始时间，Unix时间戳。
	endtime	false	int	结束时间，Unix时间戳。
	sort	false	int	排序方式。默认为0，按时间排序；为1时按与中心点距离进行排序。
	count	false	int	单页返回的记录条数，最大为50，默认为20。
	page	false	int	返回结果的页码，默认为1。
	base_app	false	int	是否只获取当前应用的数据。0为否（所有数据），1为是（仅当前应用），默认为0。
	offset	false	int	传入的经纬度是否是纠偏过，0：没纠偏、1：纠偏过，默认为0。
	*/

		$this->init();	
		$getjson = $this->api_url . 'place/nearby_timeline.json?';
		if($lat != NULL) $getjson = $getjson .  '&lat=' . $lat;
		if($long != NULL) $getjson = $getjson .  '&long=' . $long;
		$getjson =$getjson .  '&access_token=' . $this->access_token;
		
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL,$getjson);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		$content = curl_exec($ch); 
		return $content;
	}
}
?>