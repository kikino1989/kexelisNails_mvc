<?php 
$user = $this->data['user'];
?>


<table class="user-profile table table-striped table-hover">
	<th colspan="2"><?php echo ucfirst("$user->firstname's Profile"); ?></th>
	<tr>
		<td>firstname</td>
		<td><?php echo ucfirst("$user->firstname"); ?></td>
	</tr>
	<tr>
		<td>lastname</td>
		<td><?php echo ucfirst("$user->lastname"); ?></td>
	</tr>
	<tr>
		<td>email</td>
		<td><?php echo $user->email; ?></td>
	</tr>
	<tr>
		<td>phone</td>
		<td><?php echo $user->phone; ?></td>
	</tr>
	<tr>
		<td>description</td>
		<td><?php echo $user->description; ?></td>
	</tr>
</table>

<img alt="user picture" src="<?php echo $this->path($user->img);?>" />
<a href="<?php echo $this->path('EmployeeAccount/editProfile');?>">Edit</a>