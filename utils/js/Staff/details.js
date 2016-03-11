
/**
 * @desc : initialized components
 */
  $(document).ready(function() {
      $('.rating-star').find('a').click(function(){
	      var employeeid = $("#employee-id").val();
	      var rating = $(this).attr('class');
	      rate(rating, employeeid);
    	  return false;
      });
      
      $('#toggle-comment-box').click(toggle_comment_box);
  });

