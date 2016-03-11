<?php 
$images = $this->data['images'];
$comments = $this->data['comments'];
$users = $this->data['users'];
$ratings = $this->data['ratings'];
?>
<div class="picture_album">
	<?php foreach ($images as $img): ?>
	<figure>
		<figcaption>
			<label>posted by: 
			<?php foreach ($users as $user): 
					if($img->ownerid === -1):
						echo "anonimous";
					elseif($user->id === $img->ownerid): 
						echo "$user->firstname $user->lastname"; 
					endif;
				endforeach;?>
			</label>
		</figcaption>
		<a href='<?php echo $this->path("Gallery/details/$img->id/1/5");?>'>
			<img class="img-thumbnail picture-img" src="<?php echo $this->path($img->path); ?>" alt="<?php echo $img->name;?>" />
		</a>
	</figure>
	<br />
	<?php endforeach;?>
</div>

	<form class="upload" enctype="multipart/form-data"
		method="post" action="<?php echo $this->path('Gallery/uploadImage/1/5');?>">
		<fieldset>
			<legend> Be famous. </legend>
			
			<label class="control-label" for="name"> give the picture a name </label>
			<input name="name" class="form-control" type="text" required /><br />
			
			<label class="control-label" for="img"> chose a picture</label>
			<input class="btn" name="img" class="form-control" type="file" required /><br />

			<input class="btn" name="submit" type="submit" value="Upload" />

		</fieldset>
	</form>
	
	<hr />
	<?php include 'utils/components/pagination.php'?>