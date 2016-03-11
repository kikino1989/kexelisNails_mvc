<?php 
$schedules = $this->data['schedules'];
?>

<table class="table table-striped table-hover">
<?php foreach ($schedules as $schedule):?>
	<th colspan="2">Your Schedule</th>
	<tr>
		<td>Day Of The Week </td>
		<td><?php echo $schedule->day; ?></td>
	</tr>
	<tr>
		<td>Start Time </td>
		<td><?php echo ($schedule->starttime === null )?"OFF":$schedule->starttime; ?></td>
	</tr>
	<tr>
		<td>End Time</td>
		<td><?php echo ($schedule->endtime === null)?"OFF":$schedule->endtime; ?></td>
	</tr>
<?php endforeach;?>
</table>