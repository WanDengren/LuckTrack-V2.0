function friends(){
	getdata(url_friends, friends_per_page, 'rig');
}

function flushFriends(data){
	console.log(data);
	if(data.users == undefined){
		$('.feed_mid').append("<div class='error'>没有您的关注好友信息！</div>");
		return;
	}

	var str = "";
	var i = 0;
	total_friens = data.total_number;
	all_fridens_pages = Math.ceil(total_friens / friends_per_page);

	str += 
		'<div id="friend" class="mod">'+
		    '<h2>'+
			    '我的关注'+
			    '&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·'+
	            '<span class="pl">&nbsp;('+
		            '<span class="all-pages">共'+all_fridens_pages+'页</span>'+
		            '&nbsp;·&nbsp;'+
		            '<span class="cur-page">当前第'+cur_friends_page+'页</span>)';

	if (all_fridens_pages > cur_friends_page) {
	str +=
					'<span id="next-page">'+
						'<a class="next-page" href="javascript:void(0);">&nbsp;下一页</a>'+
					'</span>';
	}

	str +=					
	            '</span>'+
		    '</h2>'+
			'<div class="list">';

	for(; i < data.users.length; i++){
		var item = data['users'][i];
		str +=
				'<div class="list-item">'+
					'<a href="javascript:void(0);">'+
						'<img class="usr-img" src="'+item['profile_image_url']+'" class="show-title" title="'+item['name']+' - 点击查看TA的轨迹">'+
					'</a>'+
					'<a href="http://weibo.com/'+item['id']+'" target="_blank" title="微博首页">'+item['name']+'</span>'+
				'</div>';
	}

	str +=
			'</div>'+
		'</div>';

    $('div.friends').empty();
	$('div.friends').html(str);
}