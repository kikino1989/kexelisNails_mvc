<?php 
$services = $this->data['services'];
?>


<form class="services-form" method="post" action="<?php echo $this->path('AdminAccount/services'); ?>">
	<legend>add new services</legend>
	
	<label class="control-label" for="name">service name</label>
	<input class="form-control" type="text" name="name" required/>
	
	<label class="control-label" for="duration">service duration</label>
	<input class="form-control" type="number" name="duration" step="30" placeholder="minutes" min="30" required/>
	
	<label class="control-label" for="price">service price</label>
	<input class="form-control" type="number" name="price" required min="1"/>
	
	<label class="control-label" for="description">service description</label>
	<textarea class="form-control" required name="description"></textarea>
	
	<input class="btn btn-default"type="submit" value="add"/>
</form>

<br />
<table class="services-table table table-striped table-hover">
	<?php foreach($services as $service): // iterate thru all the employees?>
		<tr><th colspan="2">Services</th></tr>
		<tr>
			<td>Service name</td>
			<td><?php echo $service->name; ?></td>
		</tr>
		<tr>
			<td>Service duration</td>
			<td><?php echo $service->duration; ?></td>
		</tr>
		<tr>
			<td>Service price</td>
			<td><?php echo $service->estimatedprice; ?></td>
		</tr>
		<tr>
			<td>Service description</td>
			<td><?php echo $service->description; ?></td>
		</tr>
		<tr>
			<td>Action</td>
			<td><a href="<?php echo $this->path("AdminAccount/editService/$service->id");?>">Edit</a> | <a href="<?php echo $this->path("AdminAccount/deleteService/$service->id");?>">Delete</a></td>
		</tr>
	<?php endforeach; // end for each service?>
</table>