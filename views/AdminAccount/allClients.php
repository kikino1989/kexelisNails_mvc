<?php
$clients = $this->data['clients'];
?>


<table class="table table-striped table-hover">
	<?php foreach($clients as $client):?>
		<th colspan="2">Clients</th>
		<tr>
			<td>Image</td>
			<td><img alt="user image" src="<?php echo $this->path($client->img);?>" /></td>
		</tr>
		<tr>
			<td>Firstname</td>
			<td><?php echo $client->firstname;?></td>
		</tr>
		<tr>
			<td>Lastname</td>
			<td><?php echo $client->lastname;?></td>
		</tr>
		<tr>
			<td>Phone</td>
			<td><?php echo $client->phone;?></td>
		</tr>
	<?php endforeach;?>
</table>

<?php include 'utils/components/pagination.php';?>