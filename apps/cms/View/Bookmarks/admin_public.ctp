<div class="grid_10">
	<div class="box round first grid">
		<h2>
			Public Bookmark</h2>

			<table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>Username</th>
					<th>Bookmark Title</th>
					<th>Bookmark Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($bookmarks as $key => $item):
				
					if($key%2)
						$class =  'even';
					else
						$class = 'odd';
				?>
				<tr class="<?php echo $class; ?> gradeX">
					<td><?php echo $item['User']['username']; ?></td>
					<td width="50%"><?php echo $this->Html->link($item['Bookmark']['title'], urldecode($item['Bookmark']['url']), array('target' => '_blank', 'escape' => false)); ?></td>
					<td><?php echo $item['Bookmark']['created']; ?></td>
				</tr>
				<?php endforeach; ?>
				
			</tbody>
		</table>
			
		</div>
	</div>
</div>