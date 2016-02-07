<?php// echo print_r($wteams) ?>
<table class="table table-hover">
	<thead>
		<tr>
			<!-- <th>#</th> -->
			<th>Team id</th>
			<th>workshop name</th>
			<th>status</th>
			<th>name</th>
			<th>email</th>
			<th>phone number</th>
			<th>State</th>
			<th>city</th>
			<th>Registered?</th>
			<th>Hospitality?</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($wteams as $index => $wteam):?>
	<?php foreach($wteam['users'] as $user): ?>
		<tr>
			<td><?php echo $index ?></td>
			<td><?php echo $wteam['workshopName'] ?></td>
			<td><?php echo $wteam['status'] ?></td>
			<td><?php echo $user->name ?></td>
			<td><?php echo $user->email ?></td>
			<td><?php echo $user->phone ?></td>
			<td><?php echo $user->state ?></td>
			<td><?php echo $user->city ?></td>
			<td><?php echo $user->registration ?></td>
			<td><?php echo $user->hospitality ?></td>
		</tr>
	<?php endforeach; ?>
	<?php endforeach; ?>
	</tbody>
</table>