<?php 
$employee = $this->data['employee'];
$checks = $this->data['checks'];
$services = $this->data['services'];
?>


<form class="employee-services-form form-horizontal" id="client_info" method="post"
	action='<?php $this->path("AdminAccount/employeeServices/$employee->id");?>' >
	<fieldset>
		<legend>set the services that the employee does</legend>

		<input type="hidden" name="post" value="post" />
		
		<div class="form-group">
			<img alt="employee image" src="<?php $this->path($employee->img);?>" />
			<label class="control-label"><?php echo "$employee->firstname $employee->lastname"; ?></label>
		</div>
		
		<hr />
		<?php for($i = 0; $i < count($services); $i++): $service = $services[$i]; // display elements?>
			<div class="checkbox">
				<label>
					<input <?php echo $checks[$i]; ?> type="checkbox" name="<?php echo $service->id;?>" value="<?php echo $service->id;?>"/> <?php echo $service->name;?>
				</label>
			</div>
			<hr />
		<?php endfor;?>
		
		<input type="submit" class="btn btn-default" id="submit" value="save" />
	</fieldset>
</form>