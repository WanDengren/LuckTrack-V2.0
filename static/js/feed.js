function getdata(url, str){
    $.ajax({
        url: url,
        type: 'post',
        data: {data: str},
        success: function(msg) {
        	var data = JSON.parse(msg);
        	
        	flushUsr(data);
        },
        error: function(msg) {
            console.log('msg: ' + msg.responseText);
        }
    });
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

function flushUsr(data){
	var  statuses = data.statuses;
	console.log(statuses);
	var i = 0;

	initmap(statuses[0]['geo']['coordinates']);

	for(; i < statuses.length; i++){
		var item = statuses[i];
		var str = weibo_item(item);
		
		$('.feed_mid').append(str);
		addmarker(item['geo']['coordinates'], str, i);
	}
}

var map_mid;
function initmap(coordinates){
	var map = new BMap.Map("map_canvas_mid");          // 创建地图实例  
	var point = new BMap.Point(coordinates[1], coordinates[0]);  // 创建点坐标  
	map.centerAndZoom(point, 15);                 // 初始化地图，设置中心点坐标和地图级别  
	map.enableScrollWheelZoom();                            //启用滚轮放大缩小
	map_mid = map;
}


function addmarker(coordinates, str, i){
	var point = new BMap.Point(coordinates[1], coordinates[0]);
	var marker = new BMap.Marker(point);
	var infoWindow = new BMap.InfoWindow(str);  // 创建信息窗口对象
	map_mid.addOverlay(marker);
	marker.addEventListener("click", function(){          
	   this.openInfoWindow(infoWindow);
	   //图片加载完毕重绘infowindow
	   document.getElementById('imgDemo').onload = function (){
	       infoWindow.redraw();   //防止在网速较慢，图片未加载时，生成的信息框高度比图片的总高度小，导致图片部分被隐藏
	   }
	});
}
/*
var map_mid;
var infowindow = new Array();

function pushinfo(str){
	var infowindow_tmp = new google.maps.InfoWindow({
		content: str,
		maxWidth: 500
	});
	infowindow.push(infowindow_tmp);
}

function initmap(coordinates){
    var myLatlng = new google.maps.LatLng(coordinates[0], coordinates[1]);
    var mapOptions = {
      zoom: 4,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    map_mid = new google.maps.Map(document.getElementById('map_canvas_mid'), mapOptions);
}

function addmaker(item, str, i){
	var addMapper = function(element,index){
		google.maps.event.addListener(element, 'click', function() {
			infowindow[index].open(map, element);
		});
	}

	pushinfo(str);

	var newLatlng = new google.maps.LatLng(item['geo'][0], item['geo'][1]);
	var loc = item['geo'][0] + ',' + item['geo'][1];
	var marker = new google.maps.Marker({
		position: newLatlng,
		map: map_mid,
		title: loc,
		index:i
	});

	addMapper(marker, i);
/*
	var lineSymbol = {
	      path: google.maps.SymbolPath.CIRCLE,
	      scale: 8,
	      strokeColor: '#393'
    };

		if(i > 0)
		{
			    lineCoordinates[i-1] = [
				new google.maps.LatLng(lat[i], lng[i]),
				new google.maps.LatLng(lat[i-1], lng[i-1])
			];

			  line[i-1] = new google.maps.Polyline({
			  path: lineCoordinates[i-1],
			  icons: [{
				icon: lineSymbol,
				offset: '100%'
			  }],
			  map: map
			});
		}
	
}
*/