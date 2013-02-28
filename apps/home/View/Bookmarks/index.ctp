<div class="bookmarks index">
	<h2><?php echo __('Bookmarks');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('url');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($bookmarks as $bookmark): ?>
	<tr>
		<td><?php echo h($bookmark['Bookmark']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($bookmark['User']['id'], array('controller' => 'users', 'action' => 'view', $bookmark['User']['id'])); ?>
		</td>
		<td><?php echo h($bookmark['Bookmark']['url']); ?>&nbsp;</td>
		<td><?php echo h($bookmark['Bookmark']['title']); ?>&nbsp;</td>
		<td><?php echo h($bookmark['Bookmark']['description']); ?>&nbsp;</td>
		<td><?php echo h($bookmark['Bookmark']['created']); ?>&nbsp;</td>
		<td><?php echo h($bookmark['Bookmark']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $bookmark['Bookmark']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $bookmark['Bookmark']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $bookmark['Bookmark']['id']), null, __('Are you sure you want to delete # %s?', $bookmark['Bookmark']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Bookmark'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
