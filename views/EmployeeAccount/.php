<?php 
$appointments = $this->data['appointments'];
$employees = $this->data['employees'];
?>
<?php require_once 'views/EmployeeAccount/nav.php';?>

<table class="table">
<tr><th colspan="6">appointments information</th></tr>
<tr><td> date </td><td> time </td><td> service </td><td> duration </td><td> employee </td><td> action </td></tr>
<?php foreach ($appointments as $appointment):?>
	<?php foreach ($employees as $employee):?>
		<?php if($employee->id === $appointment->employeeid):?>	
			<tr>
				<td><?php echo date("M d Y",strtotime($appointment->date));?></td>
				<td><?php echo date("H:i a",strtotime($appointment->time));?></td>
				<td><?php echo $appointment->service;?></td>
				<td><?php echo $appointment->duration;?></td>
				<td><?php echo "$employee->firstname $employee->lastname";?></td>
				<td><a href="<?php echo $this->path("Account/cancel/$appointment->id");?>">CANCEL</a></td>
			</tr>
		<?php endif;?>
	<?php endforeach;?>
<?php endforeach;?>
</table>