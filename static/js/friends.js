function friends(){
	var data = {};
	data['count'] = pageParm['friends']['per_page'];
	data['cursor'] = pageParm['friends']['next_cursor'];

	getdata(urlParam['friends'], JSON.stringify(data), 'friends');
}

function flushFriends(data){
	console.log(data);
	selector = $('div.friend-list');
	if(data.users == undefined){
		selector.append("<div class='error'>没有您的关注好友信息！</div>");
		return;
	}

	pageParm['friends']['next_cursor'] = data.next_cursor;
	pageParm['friends']['total'] = data.total_number;

	if(data.next_cursor == 0){
		$('span#next-page').remove();
	}

	selector.children('div.process').remove();

	var i = 0;
	for(; i < data.users.length; i++){
		var item = data['users'][i];
		var str = "";
		str +=
				'<div class="list-item">'+
					'<a href="javascript:void(0);">'+
						'<img class="usr-img" uid="'+item['id']+'" src="'+item['profile_image_url']+'" class="show-title" title="'+item['name']+' - 点击查看TA的轨迹"/>'+
					'</a>'+
					'<a href="http://weibo.com/'+item['id']+'" target="_blank" title="'+item['name']+' - 微博首页">'+item['name']+'</span>'+
				'</div>';

		selector.prepend(str);

		$('img.usr-img:first').bind('click', function() {
			friends_up();

			var data = {};
			var uid = $(this).attr('uid');
			data['uid'] = parseInt(uid);
			pageParm['rig']['page'] = 1;
			data['page'] = pageParm['rig']['page'];
			data['count'] = pageParm['rig']['per_page'];
			
			getdata(urlParam['place_usr'], JSON.stringify(data), 'rig');
		});
	}
}