<?php 
$services = $this->data['services'];
$employees = $this->data['employees']; 
$dates = $this->data['dates'];
$times = $this->data['times'];
$serviceFilters = $this->data['serviceFilters'];
$scheduleFilters = $this->data['scheduleFilters'];
$defaultTime = $this->data['defaultTime'];
$firstService = $this->data['firstService']
?>


<form class="schedule-form" id="schedule" method="post"
	action="<?php echo $this->path('Account/schedule');?>" >
	<fieldset class="form-group">
		<legend> Fill up the Form </legend>

		<label for="date" class="control-label">select the date: </label> 
		<select class="form-control" name="date" id="date">
			<?php foreach ($dates as $date):?>
			<option value="<?php echo $date; ?>"><?php echo date('d M y',$date);?></option>
			<?php endforeach;?>
		</select> 
		
		<label for="time" class="control-label">select the time: </label> 
		<select class="form-control" name="time" id="time">
			<?php foreach ($times as $time):?>
			<option value="<?php echo $time; ?>"><?php echo date('h:i a',$time);?></option>
			<?php endforeach;?>
		</select>
		
		<label for="service" class="control-label">select the time: </label> 
		<select class="form-control" name="service" id="service">
			<?php foreach ($services as $service):?>
			<option value="<?php echo $service->id?>"><?php echo $service->name;?></option>
			<?php endforeach;?>
		</select>
		
		
		<label for="employee">select your employee for this service</label>
		<select class="form-control employee" name="employee"  >
			<option value="-1" >--select staff--</option>
				<?php foreach ($employees as $employee): // iterates thru the employees?>
					<?php foreach($serviceFilters as $serviceFilter): // iteraties thru the services filters?>
						<?php foreach ($scheduleFilters as $scheduleFilter): // iteraties thru schedules filters?>
									
							<?php if($firstService->id === $serviceFilter->serviceid && // filter the employees based on the schedule and the service
								  	 $employee->id === $serviceFilter->employeeid && 
								  	 $scheduleFilter->employeeid === $employee->id && // checks if the employee starts working at the especified time
								   	 $defaultTime >= $scheduleFilter->starttime &&
								     $defaultTime <= $scheduleFilter->endtime):?>
											 
										<option value="<?php echo $employee->id; ?>" >
											<?php echo "$employee->firstname $employee->lastname";?>
										</option>
						    <?php endif; // end filtering?>
						<?php endforeach; // end schedule filters iteration?>
					<?php endforeach; // end service filters iteration?>
				<?php endforeach; // end employee iterations?>

		<input type="submit" class="btn btn-warning" name="submit" id="submit"
			value="submit" /> <a href="<?php echo $this->path('Account/index');?>"> CANCEL</a>

	</fieldset>
</form>
