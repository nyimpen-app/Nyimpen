<div class="grid_10">
	<div class="box round first fullpage">
		<h2>
			Form Controls</h2>
		<div class="block ">
			<?php echo $this->Session->flash(); ?>
			<form method="post" action="/settings/option">
			<?php echo $this->Form->input('Setting._id', array('class' => 'mini')); ?>
			<table class="form">
				<tr>
					<td>
						<label>
							Site Url</label>
					</td>
					<td>
						<?php echo $this->Form->text('Setting.site_url', array('class' => 'mini')); ?>
					</td>
				</tr>
				<tr>
					<td>
						<label>
							Site Title/Name</label>
					</td>
					<td>
						<?php echo $this->Form->text('Setting.site_title', array('class' => 'mini')); ?>
					</td>
				</tr>
				<tr>
					<td>
						<label>
							Site Description</label>
					</td>
					<td>
						<?php echo $this->Form->text('Setting.site_description', array('class' => 'large')); ?>
					</td>
				</tr>
				<tr>
					<td>
						<label>
							Site Keyword</label>
					</td>
					<td>
						<?php echo $this->Form->text('Setting.site_keyword', array('class' => 'large')); ?>
					</td>
				</tr>
				<tr>
					<td>
						<label>
							Email Webmaster</label>
					</td>
					<td>
						<?php echo $this->Form->text('Setting.email_admin', array('class' => 'mini')); ?>
					</td>
				</tr>
					<tr>
					<td>
						<label>
							Email Sales</label>
					</td>
					<td>
						<?php echo $this->Form->text('Setting.email_sales', array('class' => 'mini')); ?>
					</td>
				</tr>
				<tr>
					<td>
						<label>
							Email technical</label>
					</td>
					<td>
						<?php echo $this->Form->text('Setting.email_technical', array('class' => 'mini')); ?>
					</td>
				</tr>
				
				
				
				<tr>
					<td>
						<?php echo $this->Form->submit('Save Setting', array('class' => 'btn btn-navy')); ?>
					</td>
					
				</tr>
				
			</table>
			</form>
		</div>
	</div>
</div>