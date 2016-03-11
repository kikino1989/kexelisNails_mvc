<?php 
$staff = $this->data['staff'];
?>

<hr />
<?php foreach ($staff as $employee) : ?>
	<div name="employee" id="employee">
		<figure>
			<figcaption>
				<label ><?php echo "$employee->firstname $employee->lastname";?></label>
			</figcaption>
			<a href="<?php echo $this->path("Staff/details/$employee->id/1/5")?>" >
				<?php if($employee->img === 'avatar'):?>
					<img class="img-thumbnail employee-img" src="<?php echo $this->path('utils/img/avatar.png'); ?>" alt="staff picture" />
				<?php else:?>
					<img class="img-thumbnail employee-img" src="<?php echo $this->path($employee->img); ?>" alt="staff picture" />
				<?php endif;?>
			</a>
			<div class="employee-desc"><?php echo $employee->description ?></div>
		</figure>
	</div>
<?php endforeach;?>

<?php include 'utils/components/pagination.php'?>