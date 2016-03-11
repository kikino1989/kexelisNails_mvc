<?php 
$employee = $this->data['employee'];
$schedule = $this->data['schedule'];
$dailySchedules = $this->data['dailySchedules'];
$times = $this->data['times'];
?>

<table class="edit-schedule-table table table-striped table-hover">
	<legend>Employee Schedule</legend>
	<tr>
		<td>Employee</td>
		<td>
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
</table>

<br />
<form class="edit-schedule-form" method="post" action="<?php echo $this->path("AdminAccount/editSchedule/$employee->id"); ?>">
	<legend>edit employee schedule</legend>
	
	<label><?php echo "$employee->firstname $employee->lastname";?></label>
	
	<label class="control-label" for="Sunday_start">Sunday</label>
	<select class="form-control" name="Sunday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Sunday'): // checks for the correct day?>
					<?php if($dailySchedule->starttime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<select class="form-control" name="Sunday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Sunday'): // checks for the correct day?>
					<?php if($dailySchedule->endtime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<br />
	
	<label class="control-label" for="Monday_start">Monday</label>
	<select class="form-control" name="Monday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Monday'): // checks for the correct day?>
					<?php if($dailySchedule->starttime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<select class="form-control" name="Monday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Monday'): // checks for the correct day?>
					<?php if($dailySchedule->endtime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<br />
	
	<label class="control-label" for="Tuesday_start">Tuesday</label>
	<select class="form-control" name="Tuesday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Tuesday'): // checks for the correct day?>
					<?php if($dailySchedule->starttime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<select class="form-control" name="Tuesday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Tuesday'): // checks for the correct day?>
					<?php if($dailySchedule->endtime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<br />
	
	<label class="control-label" for="Wednesday_start">Wednesday</label>
	<select class="form-control" name="Wednesday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Wednesday'): // checks for the correct day?>
					<?php if($dailySchedule->starttime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<select class="form-control" name="Wednesday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Wednesday'): // checks for the correct day?>
					<?php if($dailySchedule->endtime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<br />
	
	<label class="control-label" for="Thursday_start">Thursday</label>
	<select class="form-control" name="Thursday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Thursday'): // checks for the correct day?>
					<?php if($dailySchedule->starttime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<select class="form-control" name="Thursday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Thursday'): // checks for the correct day?>
					<?php if($dailySchedule->endtime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<br />
	
	<label class="control-label" for="Friday_start">Friday</label>
	<select class="form-control" name="Friday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Friday'): // checks for the correct day?>
					<?php if($dailySchedule->starttime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<select class="form-control" name="Friday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Friday'): // checks for the correct day?>
					<?php if($dailySchedule->endtime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<br />
	
	<label class="control-label" for="Saturday_start">Saturday</label>
	<select class="form-control" name="Saturday_start">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Saturday'): // checks for the correct day?>
					<?php if($dailySchedule->starttime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<select class="form-control" name="Saturday_end">
		<option value="null">---OFF---</option>
		<?php foreach($times as $time): // iterating thru all the times?>
			<?php foreach($dailySchedules as $dailySchedule): // iterating thru all the daily schedules?>
			
				<?php if($dailySchedule->day === 'Saturday'): // checks for the correct day?>
					<?php if($dailySchedule->endtime === date('H:i:s', $time)): // checks for the selected time?>
						
						<option value="<?php echo $time;?>" selected><?php echo date('h:i a', $time); ?></option>
					<?php else:?>
						<option value="<?php echo $time;?>"><?php echo date('h:i a', $time); ?></option>
						
					<?php endif; // end of the selected time?>
				<?php endif; // end of the selected day?>
				
			<?php endforeach; // end of daily schedule iteration?>
		<?php endforeach; // end of times iteration?>
	</select>
	<br />
	
	<input class="btn btn-default" type="submit" value="save"/>
</form>
<a class="back" href="<?php echo $this->path('AdminAccount/schedules');?>">Back</a>