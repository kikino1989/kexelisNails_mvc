/**
 * @desc : get the correct location for a link
 */
function getLocation(_location){
	var location = window.location.href;
	var size = location.split('/').length;
	var pre = "";
	
	if (size > 1) {
		for(var i = 0; i < size - 5; i ++) {
			pre += "../";
		}
	}else {
		pre = "";
	}

	return pre + _location;
}

/**
 * @desc : stores the rating for the entity.
 */
function rate(value, entityid){
	$.post(getLocation('Gallery/rate'),{'rate' : value, 'entityid' : entityid});
	$("#rate").html(value);
}

/**
 * toggle comment box in the pages.
 */
function toggle_comment_box() {
	if ($(this).val() == 'show') {
		
		$(this).val('hide');
		$('#comment-box').show();
		$('#comment').show();
	} else {
		
		$(this).val('show');
		$('#comment-box').hide();
		$('#comment').hide();
	}
}