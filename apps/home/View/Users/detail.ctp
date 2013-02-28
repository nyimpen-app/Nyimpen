<div class="vcard">
  <h2 class="alt"> <span class="fn ">
		<?php
			$name = $user['User']['firstname'];
			
			if(isset($user['User']['lastname'])) 
				$name .= ' '. $user['User']['lastname'];
			
			echo $name;
		
		?>
	</span> (<span class="nickname"><?php echo $user['User']['username']; ?></span>).</h2>
	<?php echo isset($user['User']['about_me']) ? $user['User']['about_me'] : 'No Description'; ?>
	
	<h2 class="alt"><?php echo $name; ?> Public Bookmark </h2>
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
									$created_time = round((time() - $this->Time->toUnix($bookmark['Bookmark']['created'])));
									if($created_time <= 86400)
									{
										echo (int) ($created_time / 60 / 60) . __(' hours ', true) . ((int) (($created_time % 3600) / 60)) . __(' minutes ago ', true);
										//echo $created_time;
									}
									else
									{
										echo round((time() - $this->Time->toUnix($bookmark['Bookmark']['created'])) / 60 / 60 / 24) . __(' days ago ', true); 
									}
							?>		
							
						</span>
						&nbsp;&bull;&nbsp;
						<span>	<?php echo $bookmark['Bookmark']['url']; ?></span>
					</div>
					<hr >
				</li>
			<?php endforeach; ?>
			
		</ul>
	</div>
  <?php /* Here is my home page:
   <a href="http://www.example.com" class="url">www.example.com</a>.
   I live in
   <span class="adr">
      <span class="locality">Albuquerque</span>,
      <span class="region">NM</span>
   </span>
   and work as an
   <span class="title">engineer</span> at
   <span class="org">ACME Corp</span>.
   My friends:
   <a href="http://darryl-blog.example.com" rel="friend">Darryl</a>,
   <a href="http://edna-blog.example.com" rel="friend">Edna</a>*/ ?>
</div>