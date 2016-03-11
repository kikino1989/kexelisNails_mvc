<?php 
$appointments = $this->data['appointments'];
$users = $this->data['users'];
?>

<table class="table table-striped table-hover">
<?php foreach ($appointments as $appointment):?>
	<?php foreach ($users as $user):?>
		<?php if($user->id === $appointment->userid):?>	
		<tr><th colspan="2">appointments history</th></tr>
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
				<td> client </td>
				<td><?php echo "$user->firstname $user->lastname";?></td>
			</tr>
		<?php endif;?>
	<?php endforeach;?>
<?php endforeach;?>
</table>

<?php include 'utils/components/pagination.php';?>