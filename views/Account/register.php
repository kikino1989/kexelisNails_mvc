<form class="register-form" method="post"
	action="<?php $this->path('index/register');?>"
	enctype="multipart/form-data">
	
	<fieldset>
		<legend> Register </legend>
		<label for="firstame" class="control-label">Enter your firstname : </label>
		<input type="text" class="form-control" name="firstname" id="firstname"
			title="enter your name without special characters " maxlength="20"
			required placeholder="Your first name here"/> 
			
		<label for="lastame" class="control-label">Enter your lastname : </label> 
		<input type="text" class="form-control" name="lastname"
			id="lastname" title="enter your lastname without special characters "
			maxlength="20" required placeholder="Your last name here" /> 
		
		<label for="phone" class="control-label">Enter your phone #: </label> 
		<input type="tel" class="form-control" name="phone"
			id="phone" title="enter your phone number " maxlength="20" required placeholder="Your phone here" />

		<label for="email" class="control-label">Enter your email : </label> 
		<input type="email" class="form-control" name="email" id="email"
			title="enter your email " maxlength="50" required placeholder="Your eamil here" /> 
			
		<label for="password" class="control-label">Enter your Password : </label> 
		<input type="password" class="form-control" name="password" id="password"
			title="enter your password here " maxlength="20" required placeholder="Your password here" /> 
		
		<label for="password2" class="control-label">Retype your Password : </label>
		<input type="password" class="form-control" name="password2" id="password2"
			title="retype your password here " maxlength="20" required placeholder="repeat password here" /> 
		
		<label for="img" class="control-label">Enter your Address: </label> 
		<input type="file" class="form-control" name="img" id="img"
			title="enter your picture here " /> 
			<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> register</button>
	</fieldset>
</form>