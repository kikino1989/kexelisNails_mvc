<?php $service = $this->data['service'];?>


<form class="edit-service-form" method="post" action="<?php echo $this->path("AdminAccount/editService/$service->id");?>">
	<fieldset class="form-group">
		<legend>
			Edit Service
		</legend>
    	
    	<label for="name" class="control-label">Service name</label>
		<input type="text" class="form-control" name="name" title="enter the service name"
		 value="<?php echo $service->name;?>" required />
		
		<label for="duration" class="control-label">Service duration</label>
		<input type="number" min="30" step="30" class="form-control" name="duration" title="enter the service duration"
		 value="<?php echo $service->duration;?>" required />
		
		<label for="price" class="control-label">Service price</label>
		<input type="number" class="form-control" name="price" title="enter the service price"
		 min="1" value="<?php echo $service->estimatedprice;?>" required />
		 
		 <label for="description" class="control-label">Service name</label>
		<textarea class="form-control" name="description" title="enter the service description" required><?php echo $service->name;?></textarea>
		
		<input type="submit" name="submit" class="btn btn-warning" id="submit" value="Save" />
		<a href="<?php echo $this->path('AdminAccount/Services');?>">CANCEL</a>
		
		
	</fieldset>
</form>