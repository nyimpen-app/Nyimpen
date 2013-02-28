<?php echo $this->Session->flash(); ?>
<h2 id="toc" class="alt">My Bookmarks</h2>
			
			<div class="bookmark">
				<ul>
					<?php foreach($bookmarks as $bookmark) : ?>
						<li>
							<?php if(!empty($bookmark['Bookmark']['image'])) : ?>
								<div class="thumb">
									<img width="120px" height="120px" src="images/test.jpg">
								</div>
							<?php endif; ?>
							
							<div class="mark_title alt">
								<?php echo $this->Html->link($bookmark['Bookmark']['title'], $bookmark['Bookmark']['url'], array('target' => '_blank')); ?>
							</div>
							
							<div class="mark_meta">
								<span class="meta_date">
									<?php  
										echo 'About ';//created time x seconds ago
										if(isset($bookmark['Bookmark']['created']->sec)) {
											$created = $bookmark['Bookmark']['created']->sec;
											$created_time = round((time() - $this->Time->toUnix($bookmark['Bookmark']['created']->sec)));
										} else {
											$created = $bookmark['Bookmark']['created'];
											$created_time = round((time() - $this->Time->toUnix($bookmark['Bookmark']['created'])));
										}
										
										if($created_time <= 86400)
										{
											echo (int) ($created_time / 60 / 60) . __(' hours ', true) . ((int) (($created_time % 3600) / 60)) . __(' minutes ago ', true);
											//echo $created_time;
										}
										else
										{
											echo round((time() - $this->Time->toUnix($created)) / 60 / 60 / 24) . __(' days ago ', true); 
										}
								?>		
								</span>
								&nbsp;&bull;&nbsp;
								<span>	<?php echo $bookmark['Bookmark']['url']; ?></span>
								<div class="meta_edit">
									<!--<a href="#"><img title="Edit" src="images/icn_edit.png"></a>-->
									&nbsp;&nbsp;
									<?php echo $this->Form->postLink($this->Html->image("/images/icn_trash.png"), array('controller' => 'bookmarks', 'action' => 'delete', $bookmark['Bookmark']['_id']), array('escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete # %s?', $bookmark['Bookmark']['title'])); ?></td> 
								</div>
							</div>
							<hr >
						</li>
					<?php endforeach; ?>
					<?php echo $this->Paging->showFrontEnd($total, $item_perpage, $current_page); ?>
					
				</ul>
			</div>
			
			

<div style="display:none;">
	<div id="form">
	<?php echo $this->Form->create('Bookmark', array('action' => 'add'));?>
		<fieldset>
			<legend><?php echo __('New Bookmark'); ?></legend>
		<?php
			echo $this->Form->input('url', array('size' => 40));
			echo $this->Form->input('is_public', array('type' => 'checkbox'));
		?>
		</fieldset>
		<?php
			$options = array(
				'label' => 'Save',
				'value' => 'Submit',
				'class' => 'green',
			  
			);
			echo $this->Form->end($options);
	?>
	</div>
	

</div>
