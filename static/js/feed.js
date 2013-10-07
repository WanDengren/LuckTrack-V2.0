function getdata(url, str, type){
	if(type == 'mid'){
		$('div.feed_mid').html(pImg);
	}else if(type == 'friends'){
		$('div.friend-list').prepend(pImg);
	}else if(type == 'rig'){
		$('div.feed_rig').prepend(pImg);
	}else if(type == 'lef'){
		$('div.feed_lef').prepend(pImg);
	}

    $.ajax({
        url: url,
        type: 'post',
        data: {data: str},
        success: function(msg) {
        	//console.log(msg);
        	var data = JSON.parse(msg);

        	if(type == 'lef' || type == 'mid' || type == 'rig'){
	        	flushUsr(data, type);
        	}else if(type == 'friends'){
        		flushFriends(data);
        	}
        },
        error: function(msg) {
            console.log('msg: ' + msg.responseText);
        }
    });
}

function flushUsr(data, type){
	var selector;
	if(type == 'mid'){
		selector = $('div.feed_mid');
	}else if(type == 'rig'){
		selector = $('div.feed_rig')
	}else if(type == 'lef'){
		selector = $('div.feed_lef');
	}
	
	if(data.statuses == undefined){
		selector.empty();
		if(data.error_code == 10023){
			selector.append("<div class='error'>您今日使用新浪api服务已到达上限，请一小时后再试！</div>");
		}else{
			selector.append("<div class='error'>没有用户的签到信息！</div>");
		}
		return;
	}

	pageParm[type]['total'] = data.total_number;
	selector.empty();

	var  statuses = data.statuses;
	console.log(statuses);
	var i = 0;
	var pre_cor;

	if (statuses[0]['geo'] == null) {
		selector.empty();
		selector.append("<div class='error'>没有用户的签到信息！</div>");
		return;
	}

	var map = initmap(statuses[0]['geo']['coordinates'], type);
	var uid = statuses[0]['user']['id'];

	for(; i < statuses.length; i++){
		var item = statuses[i];
		var str = weibo_item(item);

		selector.append(str);

		var yuanfen = selector.children('div.status-item:last').find('a.yuanfen');
		yuanfen.bind('click', function() {
			data = {};
			data['lat'] = $(this).attr('lat');
			data['long'] = $(this).attr('long');
			console.log(data);
			slide_lef();
			$('div.feed_lef').empty();
			getdata(urlParam['place_nearby'], JSON.stringify(data), 'lef');
		});

		addmarker(map, item['geo']['coordinates'], str);

		if(i > 0 && type != "lef"){
			addline(map, item['geo']['coordinates'], pre_cor);
		}

		pre_cor = item['geo']['coordinates'];
	}

	if(type == 'lef'){
		return;
	}

	var more_feed = '<div class="more-feed" uid="'+uid+'">'+'<span class="more-feed">下一页</span>'+'</div>';
	var no_more_feed = '<div class="no-more-feed">'+'<span>没有下一页了o(╯□╰)o</span>'+'</div>';

	if(pageParm[type]['page'] * pageParm[type]['per_page'] < data.total_number){
		pageParm[type]['page']++;

		selector.prepend(more_feed);

		$('div.more-feed').bind('click', function() {
			if(pageParm[type]['page'] != -1){
				var data = {};
				data['uid'] = parseInt($(this).attr('uid'));
				data['page'] = pageParm[type]['page'];
				data['count'] = pageParm[type]['per_page'];
				console.log(data);
				getdata(urlParam['place_usr'], JSON.stringify(data), type);
			}else{
				alert("没有下一页了");
			}
		});
	}else{
		selector.prepend(no_more_feed);
		pageParm[type]['page'] = -1;
	}
}


function weibo_item(item){
	str = "";
	str += 
		'<div class="status-item">' +
			'<div class="head">' +
				'<a href="http://weibo.com/'+item['user']['id']+'" target="_blank" title="'+item['user']['name']+'" >' +
					'<img title="'+item['name']+'" src="'+item['user']['profile_image_url']+'" target="_blank" >' +
				'</a>' +
			'</div>' +
			'<div class="body" >' +
				'<p class="text" >' +
					'<a class="name" href="http://weibo.com/'+item['user']['id']+'" target="_blank">'+item['user']['name']+'</a>:' +
					'<span>' + item['text'] + '</span>' +
				'</p>';

	if(item['pic_ids'].length > 0){
		str +=	'<div class="attach">';
		var j = 0;
		for(; j < item['pic_ids'].length; j++){
		str += 		'<a href="http://ww3.sinaimg.cn/large/'+item['pic_ids'][j]+'.jpg" target="_blank">'+
						'<img src="http://ww3.sinaimg.cn/thumbnail/'+item['pic_ids'][j]+'.jpg">'+
					'</a>';
		}

		str += '</div>';
	}

	str+=							
				'<div class="actions">' +
					'<span class="info">' +
						'<a href="javascript:void(0);" title="'+item['created_at']+'" >' + item['created_at'].substring(4, 10) + item['created_at'].substring(25) +'</a>' +
						item['source'] +
					'</span>' +
					'<span class="operation">' +
						'<a class="comment" href="http://api.weibo.com/2/statuses/go?uid='+ item['user']['id']+  '&id='+item['id']+'" target="_blank">评论('+ item['comments_count']+')</a>' +
						'<a class="yuanfen" lat="'+item['geo']['coordinates'][0]+'" long="'+item['geo']['coordinates'][1]+'" href="javascript:void(0);">缘分轨迹</a>' +
					'</span>' +
				'</div>' +
			'</div>' +
		'</div>';

	return str;
}
