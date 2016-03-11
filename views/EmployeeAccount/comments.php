<?php 
$clients = $this->data['clients'];
$comments = $this->data['comments'];
$rating = $this->data['rating'];
?>


<h3>your rating : <?php echo $rating->rate;?></h3>
<div>
	<?php foreach ($comments as $comment):?>
		<?php foreach($clients as $client):?>
			<?php if($client->id === $comment->ownerid):?>
				<div class="comment">
					<img alt="user image" src="<?php echo $this->path($client->img);?>" /><br />
					posted by : <?php echo "$client->firstname $client->lastname";?><br />
					on : <?php echo date("d/m/Y",strtotime($comment->date));?>
					<pre><?php echo $comment->text;?></pre>
				</div>
			<?php endif;?>
		<?php endforeach;?>
	<?php endforeach;?>
</div>