function friends_up(){
	height = $('div.friends').css('height');
	$('div.friends').animate({'margin-top': '-' + height}, 500);
	var imgSelector = $('a.friends-up').children('img:first');
	imgSelector.addClass('arrow_down');
	imgSelector.removeClass('arrow_up');
	imgSelector.attr('src', urlParam['img'] + '/arrow_down.png');

}

function friends_down(){
	$('div.friends').animate({'margin-top': '0px'}, 500);
	var imgSelector = $('a.friends-up').children('img:first');
	imgSelector.addClass('arrow_up');
	imgSelector.removeClass('arrow_down');
	imgSelector.attr('src', urlParam['img'] + '/arrow_up.png');
}

function slide_lef(){
	$('#slides').animate({'margin-left': '0px'}, 500);
	$('img#left, img#middle, img#right').removeClass();
	$('img#middle, img#right').addClass('inact');
	$('img#left').addClass('act');	
}

$(function() {
	$('a.mid').bind('click', function() {
		$('#slides').animate({'margin-left': '-760px'}, 500);
		$('img#left, img#middle, img#right').removeClass();
		$('img#left, img#right').addClass('inact');
		$('img#middle').addClass('act');
	});

	$('a.lef').bind('click', function() {
		slide_lef();
	});

	$('a.rig').bind('click', function() {
		$('#slides').animate({'margin-left': '-1520px'}, 500);
		$('img#left, img#middle, img#right').removeClass();
		$('img#left, img#middle').addClass('inact');
		$('img#right').addClass('act');		
	});

	$('a.friends-up').bind('click', function(){
		className = $(this).children('img:first').attr('class');
		if(className == 'arrow_up'){
			friends_up();
		}else if(className == 'arrow_down'){
			friends_down();
		}
	});
});

