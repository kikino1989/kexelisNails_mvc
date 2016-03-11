<?php 
$appointments = $this->data['appointments'];
$employees = $this->data['employees'];
?>

<table class="upcoming table table-striped table-hover">
<?php foreach ($appointments as $appointment):?>
	<?php foreach ($employees as $employee):?>
		<?php if($employee->id === $appointment->employeeid):?>	
			<tr><th colspan="6">appointments information</th></tr>
			<tr>
				<td> date </td>
				<td><?php echo date("M d Y",strtotime($appointment->date));?></td>
			</tr>
			<tr>
				<td> time </td>
				<td><?php echo date("H:i a",strtotime($appointment->time));?></td>
			</tr>
			<tr>
				<td> service </td>
				<td><?php echo $appointment->service;?></td>
			</tr>
			<tr>
				<td> duration </td>
				<td><?php echo $appointment->duration;?></td>
			</tr>
			<tr>
				<td> employee </td>
				<td><?php echo "$employee->firstname $employee->lastname";?></td>
			</tr>
			<tr>
				<td> action </td>
				<td><a href="<?php echo $this->path("Account/cancel/".$appointment->id);?>">CANCEL</a></td>
			</tr>
		<?php endif;?>
	<?php endforeach;?>
<?php endforeach;?>
</table>

<?php include 'utils/components/pagination.php';?>