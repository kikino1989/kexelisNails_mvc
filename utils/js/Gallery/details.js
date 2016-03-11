
/**
 * @desc : initialized components
 */
  $(document).ready(function() {
      $('.rating-star').find('a').click(function(){
	      var imageid = $("#image-id").val();
	      var rating = $(this).attr('class');
	      rate(rating, imageid);
    	  return false;
      });
      
      $('#toggle-comment-box').click(toggle_comment_box);
  });



