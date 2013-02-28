<div class="grid_10">
	<div class="box round first grid">
		<h2>
			Tables & Grids</h2>
		<div class="block">
			
			
			
			<table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>Username</th>
					<th>E-mail</th>
					<th>Fullname</th>
					<th>Role</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($users as $key => $user):
				
					if($key%2)
						$class =  'even';
					else
						$class = 'odd';
				?>
				<tr class="<?php echo $class; ?> gradeX">
					<td><?php echo $user['User']['username']; ?></td>
					<td><?php echo $user['User']['email']; ?></td>
					<td><?php
							$name = $user["User"]["firstname"];
							if(isset($user["User"]["lastname"]))
								$name .= ' ' . $user['User']['lastname'];
								
							echo $name;
						?></td>
					<td class="center"><?php echo $user['User']['role']; ?></td>
				</tr>
				<?php endforeach; ?>
				
			</tbody>
		</table>
			
			
			
		</div>
	</div>
</div>