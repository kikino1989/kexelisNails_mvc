<?php 
$image = $this->data['image'];
$comments = $this->data['comments'];
$rating = $this->data['rating'];
$users = $this->data['users'];
$params = "/$image->id";
?>

	<div id="employee">
			<figure>
				<img class="img-thumbnail" src="<?php echo $this->path($image->path); ?>" alt="staff picture" />
				<figcaption>
					<label class="label label-info"></label>
					<div name="details">
						rating : <label><?php echo $rating->rate; ?></label>
						<?php foreach ($comments as $comment):?>
							<div class="comment">
								posted by : <?php foreach ($users as $user): if($user->id === $comment->ownerid): echo "$user->firstname $user->lastname"; endif; endforeach;?> 
								<div style="overflow:hidden;word-wrap: break-word;"><?php echo $comment->text; ?></div>
							</div>
							<hr />
						<?php endforeach;?>
					</div>
				</figcaption>
			</figure>
	</div>
	
	<div class="rater">
		<input type="hidden" id="image-id" value="<?php echo $image->id; ?>" />
		<?php include 'utils/components/rating-stars.php'?>
		<label id="rate"><?php echo $rating->rate;?></label>
	</div>
	
	<form class="comment-it" action="<?php echo $this->path('Gallery/comment/1/5');?>" method="post">
		
		<label class="label label-info" for="text">post your comments here:</label>
		<input id="toggle-comment-box"  class="btn btn-link" type="button" value="Show" />
			
		<textarea name="text" id="comment-box" class="form-control comment-box" placeholder="you comment here"></textarea>
		
		<input name="entityid" type="hidden" value="<?php echo $image->id;?>" /> 
		
		<input id="comment" class="btn btn-default" type="submit" value="comment" />
	</form>
	
	<a class="back" href="<?php echo $this->path('Gallery/index/1/5');?>">BACK</a>
	
	<?php include 'utils/components/pagination.php';?>