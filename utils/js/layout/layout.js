// toggle menu
$(document).ready(function(){
	$('#menu-btn').click(function(){
		if($('#folding-menu').attr('class') === 'sh'){
			$('#folding-menu').attr('class', 'hid');
		}else{
			$('#folding-menu').attr('class', 'sh');
		}
	});
});