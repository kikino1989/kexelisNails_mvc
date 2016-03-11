<?php 
$employees = $this->data['employees'];
$schedules = $this->data['schedules'];
$times = $this->data['times'];
?>


<form class="schedule-form" method="post" action="<?php echo $this->path('AdminAccount/schedules'); ?>">
	<legend>add new employee schedule</legend>
	
	<select class="form-control" name="employee">
		<?php foreach($employees as $employee):?>
			<option value="<?php echo $employee->id;?>"><?php echo "$employee->firstname $employee->lastname";?></option>
		<?php endforeach;?>
	</select>
	<br />
	
	<label class="control-label" for="Sunday">Sunday</label>
	<select class="form-control" name="Sunday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	<select class="form-control" name="Sunday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	<br />
	
	<label class="control-label" for="Monday">Monday</label>
	<select class="form-control" name="Monday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	<select class="form-control" name="Monday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	<br />
	
	<label class="control-label" for="Tuesday">Tuesday</label>
	<select class="form-control" name="Tuesday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	<select class="form-control" name="Tuesday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	<br />
	
	<label class="control-label" for="Wednesday">Wednesday</label>
	<select class="form-control" name="Wednesday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	<select class="form-control" name="Wednesday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	<br />
	
	<label class="control-label" for="Thursday">Thursday</label>
	<select class="form-control" name="Thursday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	<select class="form-control" name="Thursday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	<br />
	
	<label class="control-label" for="Friday">Friday</label>
	<select class="form-control" name="Friday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	<select class="form-control" name="Friday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	<br />
	
	<label class="control-label" for="Saturday">Saturday</label>
	<select class="form-control" name="Saturday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	<select class="form-control" name="Saturday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time):?>
			<option value="<?php echo $time;?>"><?php echo date('h:i a', $time);?></option>
		<?php endforeach;?>
	</select>
	
	<input class="btn btn-default" type="submit" value="add"/>
</form>

<br />
<table class="schedule-table table table-striped table-hover">
	<?php foreach($employees as $employee): // iterate thru all the employees?>
		<?php foreach($schedules as $schedule): // iterate thru all the schedules?>
			<?php if($employee->id === $schedule->employeeid): // checks the correct schedule for the employee?>
			<tr><th colspan="2">Employee schedules</th></tr>
			<tr>
				<td><td>Employee</td>
					<img alt="employee image" src="<?php echo $this->path($employee->img);?>" /><br />
					<?php echo "$employee->firstname $employee->lastname";?>
				</td>
			</tr>
			<tr>
				<td>Sunday</td>
				<td><?php echo $schedule->Sunday;?></td>
			</tr>
			<tr>
				<td>Monday</td>
				<td><?php echo $schedule->Monday;?></td>
			</tr>
			<tr>
				<td>Tuesday</td>
				<td><?php echo $schedule->Tuesday;?></td>
			</tr>
			<tr>
				<td>Wednesday</td>
				<td><?php echo $schedule->Wednesday;?></td>
			</tr>
			<tr>
				<td>Thursday</td>
				<td><?php echo $schedule->Thursday;?></td>
			</tr>
			<tr>
				<td>Friday</td>
				<td><?php echo $schedule->Friday;?></td>
			</tr>
			<tr>
				<td>Saturday</td>
				<td><?php echo $schedule->Saturday;?></td>
			</tr>
			<tr>
				<td>Action</td>
				<td>
					<a title="edits the schedule for the selected employee" href="<?php echo $this->path("AdminAccount/editSchedule/$employee->id") ?>">Edit</a> |
					<a title="edits the schedule for the selected employee" href="<?php echo $this->path("AdminAccount/deleteSchedules/$employee->id"); ?>">Delete</a>
				</td>
			</tr>
			<?php endif;?>
		<?php endforeach; // end for each schedule?>
	<?php endforeach; // end for each employee?>
</table>

<?php include 'utils/components/pagination.php';?>