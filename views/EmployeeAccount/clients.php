<?php 
$clients = $this->data['clients'];
?>

<table class="table table-striped table-hover">
	<?php foreach ($clients as $client):?>
		<tr><th colspan="2">Your clients so far</th></tr>
		<tr>
			<td>image</td>
			<td><img alt="user image" src="<?php echo $this->path($client->img); ?>" /></td>
		</tr>
		<tr>
			<td>firstname</td>
			<td><?php echo $client->firstname;?></td>
		</tr>
		<tr>
			<td>lastname</td>
			<td><?php echo $client->lastname;?></td>
		</tr>
		<tr>
			<td>phone</td>
			<td><?php echo $client->phone;?></td>
		</tr>
	<?php endforeach;?>
</table>

<?php include 'utils/components/pagination.php';?>