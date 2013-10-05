$(function() {
	$('a.mid').bind('click', function() {
		$('#slides').animate({'margin-left': '-760px'}, 500);
		$('img#left, img#middle, img#right').removeClass();
		$('img#left, img#right').addClass('inact');
		$('img#middle').addClass('act');
	});

	$('a.lef').bind('click', function() {
		$('#slides').animate({'margin-left': '0px'}, 500);
		$('img#left, img#middle, img#right').removeClass();
		$('img#middle, img#right').addClass('inact');
		$('img#left').addClass('act');
	});

	$('a.rig').bind('click', function() {
		$('#slides').animate({'margin-left': '-1520px'}, 500);
		$('img#left, img#middle, img#right').removeClass();
		$('img#left, img#middle').addClass('inact');
		$('img#right').addClass('act');		
	});
});