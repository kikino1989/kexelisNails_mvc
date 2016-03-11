<?php $user = $this->data['user'];?>


<form method="post" class="profile-form form" action="<?php echo $this->path('EmployeeAccount/editProfile');?>" enctype="multipart/form-data">
	<fieldset class="form-group">
		<legend>
			Edit your information
		</legend>
    	
    	<label for="firstame" class="control-label">Enter your firstname : </label>
		<input type="text" class="form-control" name="firstname" id="firstname" title="enter your name without special characters "
		 maxlength="20" value="<?php echo ucfirst($user->firstname);?>" required />
		
		<label for="lastame" class="control-label">Enter your lastname : </label>
		<input type="text" class="form-control" name="lastname" id="lastname" title="enter your lastname without special characters "
		 maxlength="20" value="<?php echo ucfirst($user->lastname); ?>" required/>
		
		<label for="phonenum" class="control-label">Enter your phone number : </label>
		<input type="tel" class="form-control" name="phone" id="phone" title="enter your phone number "
		 maxlength="10" value="<?php echo ucfirst($user->phone);?>" required />
		
		<label for="email" class="control-label">Enter your email : </label>
		<input type="email" class="form-control" name="email" id="email" title="enter your email "
		 maxlength="50" value="<?php echo $user->email;?>" required/>
		
		<label for="password" class="control-label">Enter your Password : </label>
		<input type="text" class="form-control" name="password" id="password" title="enter your password here "
		 maxlength="20" value="<?php echo $user->password;?>" required/>
		
		<label for="description" class="control-label">Description</label>
		<textarea name="description" class="form-control" id=comment max="500"></textarea>
		
		<img alt="user's picture" src="<?php echo $this->path($user->img);?>" />	    						
		<label for="img" class="control-label">Enter your Address: </label>
		<input type="file" class="img form-control"" name="img" id="img" title="enter your picture here " />
		
		<input type="submit" name="submit" class="btn btn-warning" id="submit" value="Save" />
		<a href="<?php echo $this->path('EmployeeAccount/profile');?>">CANCEL</a>
		
		
	</fieldset>
</form>