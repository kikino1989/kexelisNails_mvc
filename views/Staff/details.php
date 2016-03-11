<?php 
$employee = $this->data['employee'];
$comments = $this->data['comments'];
$rating = $this->data['rating'];
$users = $this->data['users'];
$params = "/$employee->id";
?>

	<div name="employee" id="employee">
			<figure>
				<figcaption>
					<label ><?php echo "$employee->firstname $employee->lastname";?></label>
				</figcaption>
				<a href="<?php echo $this->path("Staff/details/$employee->id/1/5")?>" >
					<?php if($employee->img === 'avatar'):?>
						<img class="img-thumbnail employee-img" src="<?php echo $this->path('utils/img/avatar.png'); ?>" alt="staff picture" />
					<?php else:?>
						<img class="img-thumbnail employee-img" src="<?php echo $this->path($employee->img); ?>" alt="staff picture" />
					<?php endif;?>
				</a>
			</figure>
	</div>
	
	<div class="rater">
		<input type="hidden" id="employee-id" value="<?php echo $employee->id; ?>" />
		<?php include 'utils/components/rating-stars.php'?>
		<label id="rate"><?php echo $rating->rate;?></label>
	</div>
	
	<?php foreach ($comments as $comment):?>
		<div class="comment">
			posted by : <?php foreach ($users as $user): if($user->id === $comment->ownerid): echo "$user->firstname $user->lastname"; endif;endforeach;?>
			<div style="overflow:hidden;word-wrap: break-word;"><?php echo $comment->text;?></div>
		</div>
		<br />
	<?php endforeach;?>
	
	<form class="comment-it" action="<?php echo $this->path('Staff/comment');?>" method="post">
		
		<label class="label label-info" for="text">post your comments here:</label>
		<input id="toggle-comment-box"  class="btn btn-link" type="button" value="Show" /> <br />
			
		<textarea name="text" id="comment-box" class="form-control comment-box" placeholder="you comment here"></textarea>
		<br /> 
		
		<input name="employeeid" type="hidden" value="<?php echo $employee->id;?>" /> 
		
		<input id="comment" class="btn btn-default" type="submit" value="comment" />
	
	</form>
	<a class="back" href="<?php echo $this->path('Staff/index/1/5');?>">BACK</a>
	
	<?php include 'utils/components/pagination.php';?>