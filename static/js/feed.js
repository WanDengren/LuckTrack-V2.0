function getdata(url, str, type){
	if(type == 'mid'){
		$('div.feed_mid').html(pImg);
	}else if(type == 'rig'){
		$('div.friends').html(pImg);
	}

    $.ajax({
        url: url,
        type: 'post',
        data: {data: str},
        success: function(msg) {
        	//console.log(msg);
        	var data = JSON.parse(msg);

        	if(type == 'mid'){
	        	total_number_mid = data.total_number;

	        	$('div.process').remove();
	        	flushUsr(data);
        	}else if(type == 'rig'){
        		flushFriends(data);
        	}
        },
        error: function(msg) {
            console.log('msg: ' + msg.responseText);
        }
    });
}

function flushUsr(data){
	if(data.statuses == undefined){
		$('.feed_mid').append("<div class='error'>没有您的签到信息！</div>");
		return;
	}

	var  statuses = data.statuses;
	console.log(statuses);
	var i = 0;
	var pre_cor;

	map_mid = initmap(statuses[0]['geo']['coordinates']);

	for(; i < statuses.length; i++){
		var item = statuses[i];
		var str = weibo_item(item);
		
		$('.feed_mid').append(str);

		addmarker(map_mid, item['geo']['coordinates'], str);

		if(i > 0){
			addline(map_mid, item['geo']['coordinates'], pre_cor);
		}

		pre_cor = item['geo']['coordinates'];
	}

	var more_feed = '<div class="more-feed">'+'<span class="more-feed">下一页</span>'+'</div>';
	var no_more_feed = '<div class="no-more-feed">'+'<span>没有下一页了o(╯□╰)o</span>'+'</div>';

	if(page_mid * per_page < total_number_mid){
		page_mid++;

		$('.feed_mid').prepend(more_feed);

		$('div.more-feed, span.more-feed').bind('click', function() {
			console.log("more");
			if(page_mid != -1){
				var data = {};
				data['page'] = page_mid;
				data['count'] = per_page;
				
				getdata(url_place_usr, JSON.stringify(data), 'mid');
			}else{
				alert("没有下一页了");
			}
		});
	}else{
		$('.feed_mid').prepend(no_more_feed);
		page_mid = -1;
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
						'<a class="yuanfen" href="javascript:void(0);">缘分轨迹</a>' +
					'</span>' +
				'</div>' +
			'</div>' +
		'</div>';

	return str;
}
