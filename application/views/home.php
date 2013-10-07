<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wb="http://open.weibo.com/wb">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>授权后的页面</title>
<link rel="stylesheet" href="<?php echo base_url("static/stylesheet/css/common.css");?>" />
<link rel="stylesheet" href="<?php echo base_url("static/stylesheet/css/weibo.css");?>" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.7.2.min.js');?>"></script>
<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript"></script>
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
				<div id="map_canvas_lef">
				</div>
				<div class="feed_lef">
					<div class='error'>
						请点击“我的轨迹”页中“缘分轨迹”查看相应位置附近的人！
					</div>
				</div>
			</div>
			<div class="slide-mid">		
				<div id="map_canvas_mid">
				</div>
			    <div class="feed_mid">
			    </div>
		    </div>
			<div class="slide-rig">
				<div class="friends">
					<div id="friend" class="mod">
					    <h2 class="follows-header">
					    	<span>
							    我的关注
							    &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·
				            </span>
        					<span id="next-page">
								<a class="next-page" href="javascript:void(0);">&nbsp;更多</a>
							</span>
					    </h2>
						<div class="friend-list">
						</div>
					</div>
				</div>
				<div>
					<a class="friends-up" href="javascript:void(0);" title="我的关注">
						<img class="arrow_up" src="<?php echo base_url('static/stylesheet/img/arrow_up.png');?>"/>
					</a>
				</div>
				<div id="map_canvas_rig">
				</div>
			    <div class="feed_rig">					
			    </div>
		    </div>		    
	    </div>
	</div>
	<script type="text/javascript">
		var process = "<?php echo base_url('static/stylesheet/img/process.gif');?>";
		var pImg = '<div class="process">' +
						'<img class="process" src="' + process + '" />' +
					'</div>';

		var pageParm = {};
		pageParm['lef'] = {};
		pageParm['lef']['page'] = 1;
		pageParm['lef']['per_page'] = 20;
		pageParm['lef']['total'] = 0;

		pageParm['mid'] = {};
		pageParm['mid']['page'] = 1;
		pageParm['mid']['per_page'] = 20;
		pageParm['mid']['total'] = 0;

		pageParm['rig'] = {};
		pageParm['rig']['page'] = 1;
		pageParm['rig']['per_page'] = 20;
		pageParm['rig']['total'] = 0;

		var urlParam = {};
		urlParam['place_usr'] = "<?php echo base_url('welcome/user');?>";
		urlParam['place_nearby'] = "<?php echo base_url('welcome/nearby');?>";
		urlParam['friends'] = "<?php echo base_url('welcome/friends');?>";
		urlParam['img'] = "<?php echo base_url('static/stylesheet/img');?>";

		pageParm['friends'] = {};
		pageParm['friends']['total'] = 0;
		pageParm['friends']['per_page'] = 24;
		pageParm['friends']['cur_page'] = 24;		
		pageParm['friends']['next_cursor'] = 0;
	</script>
	<script type="text/javascript" src="<?php echo base_url('static/js/slide.js');?>"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA_XsYXNKzF7lw5GBnVt0GfR4PUwcyCaJQ&sensor=true">></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/map.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/feed.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/friends.js');?>"></script>
	<script type="text/javascript">
	$(function() {
		$('a.next-page').bind('click', function() {
			friends('next');
		});

		var data = {};
		data['uid'] = null;
		data['page'] = pageParm['mid']['page'];
		data['count'] = pageParm['mid']['per_page'];

		getdata(urlParam['place_usr'], JSON.stringify(data), 'mid');
		friends();
	});
	</script>
</body>
</html>