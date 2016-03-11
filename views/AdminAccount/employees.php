<?php 
$employees = $this->data['employees'];
?>


<form class="employee-form" id="client_info" method="post"
	action="<?php $this->path('AdminAccount/register');?>"
	enctype="multipart/form-data">
	<fieldset class="form-group">
		<legend> Register </legend>
		
		<label for="firstame" class="control-label">Enter your firstname : </label>
		<input type="text" class="form-control" name="firstname" id="firstname"
			title="enter your name without special characters " maxlength="20"
			required /> 
			
		<label for="lastame" class="control-label">Enter your lastname : </label> 
		<input type="text" class="form-control" name="lastname"
			id="lastname" title="enter your lastname without special characters "
			maxlength="20" required /> 
		
		<label for="phone" class="control-label">Enter your phone #: </label> 
		<input type="tel" class="form-control" name="phone"
			id="phone" title="enter your phone number " maxlength="20" required />

		<label for="email" class="control-label">Enter your email : </label> 
		<input type="email" class="form-control" name="email" id="email"
			title="enter your email " maxlength="50" required /> 
			
		<label for="password" class="control-label">Enter your Password : </label> 
		<input type="password" class="form-control" name="password" id="password"
			title="enter your password here " maxlength="20" required /> 
		
		<label for="password2" class="control-label">Retype your Password : </label>
		<input type="password" class="form-control" name="password2" id="password2"
			title="retype your password here " maxlength="20" required /> 
		
		<label for="description">Description</label>
		<textarea class="form-control" name="description" id=comment max="500"></textarea>
		
		<label class="control-label" for="role">select role:</label>
		<select class="form-control" name="role">
			<option value="employee">employee</option>
			<option value="admin">admin</option>
		</select>
		
		<label for="img" class="control-label">Enter your Address: </label> 
		<input type="file" class="img form-control" name="img" id="img"
			title="enter your picture here " /> 
			<input type="submit" name="submit" class="btn btn-default" id="submit" value="register" />
	</fieldset>
</form>

<br />
<form method="post" action="<?php echo $this->path('AdminAccount/deleteMany')?>">
	<table class="employee-table table table-striped table-hover">
		<?php foreach($employees as $employee):?>
			<th colspan="2">Employeees</th>
			<tr>
				<td>select</td>
				<td><input type="checkbox" name="<?php echo $employee->id;?>" value="<?php echo $employee->id;?>" /></td>
			</tr>
			<tr>
				<td>image</td>
				<td><img alt="employee image" src="<?php echo $this->path($employee->img);?>" /></td>
			</tr>
			<tr>
				<td>firstname</td>
				<td><?php echo $employee->firstname; ?></td>
			</tr>
			<tr>
				<td>lastname</td>
				<td><?php echo $employee->lastname; ?></td>
			</tr>
			<tr>
				<td>email</td>
				<td><?php echo $employee->email; ?></td>
			</tr>
			<tr>
				<td>phone</td>
				<td><?php echo $employee->phone; ?></td>
			</tr>
			<tr>
				<td>action</td>
				<td>
					<a title="delete this employee" href="<?php echo $this->path('AdminAccount/employeeServices/'.$employee->id);?>">Add Service</a> | 
					<a title="delete this employee" href="<?php echo $this->path('AdminAccount/delete/'.$employee->id);?>">Delete</a>
				</td>
			</tr>
		<?php endforeach;?>
		<tr><td colspan="2"><input class="btn btn-default" type="submit" value="delete"/></td></tr>
	</table>
	
	
</form>

<?php include 'utils/components/pagination.php';?>