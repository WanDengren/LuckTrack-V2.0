<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wb="http://open.weibo.com/wb">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>授权后的页面</title>
<link rel="stylesheet" href="<?php echo base_url("static/stylesheet/css/common.css");?>" />
<link rel="stylesheet" href="<?php echo base_url("static/stylesheet/css/weibo.css");?>" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.7.2.min.js');?>"></script>
<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/slide.js');?>"></script>
</head>
<body>
	<div id="gallery">
	    <div id = 'menu'>
			<ul class="menu_items">
				<li class="menuItem left">
					<a href="javascript:void(0);" class="lef" title="附近的人">
						<img id='left' class="inact" src ='<?php echo base_url('static/stylesheet/img/nearby.png');?>' title='附近的人'>
					</a>
				</li>
				<li class="menuItem mid">
					<a href="javascript:void(0);" class="mid" title="首页-我的轨迹">
						<img id='middle' class="act" src='<?php echo base_url('static/stylesheet/img/home.png');?>' title='首页-我的轨迹'>
					</a>
				</li>
				<li class="menuItem rig">
					<a href="javascript:void(0);" class="rig" title="TA的轨迹">
						<img id='right' class="inact" src='<?php echo base_url('static/stylesheet/img/friends.png');?>' title='TA的轨迹'>
					</a>
				</li>
			</ul>
		</div>	
	    <div id="slides">
			<div class="slide-lef">	
				<div class="map_canvas_lef">
				</div>
				<div class="feed">
					<a href="javascript:void(0);" class="lef">附近的人</a>
				</div>
			</div>
			<div class="slide-mid">		
				<div class="map_canvas_mid">
				</div>
			    <div class="feed">
					<a href="javascript:void(0);" class="mid">首页</a>
			    </div>
		    </div>
			<div class="slide-rig">				
				<div class="map_canvas_rig">
				</div>
			    <div class="feed">
					<a href="javascript:void(0);" class="rig">TA的轨迹</a>
			    </div>
		    </div>		    
	    </div>
	</div>
<script type="text/javascript">
$(function() {
	function map_feed(str){
	    $.ajax({
	        url: '<?php echo base_url("welcome/user");?>',
	        type: 'post',
	        data: {data: str},
	        success: function(msg) {

	        },
	        error: function(msg) {
	            console.log('msg: ' + msg.responseText);
	        }
	    });
	}
});
</script>	
</body>
</html>