
/**
 * @desc : initialized components
 */
  $(document).ready(function() {
      $('.rating-star').find('a').each(function(){
    	  $(this).css("background-color":"red");
    	  /*$(this).click(function(){
	    	  
    		  alert("c");
    		  var starVal = $(this).val();
	    	  var entityid = $(this).prev('input').val();
	    	  rate(starVal, entityid);
    	  });*/
      });
  });

/**
 * @desc : stores the rating for the entity.
 */
function rate(value, entityid){
	$.post(getLocation('Gallery/rate'),{'rate' : value, 'entityid' : entityid});
}

