<?php echo $this->Session->flash(); ?>

<h3 id="toc" class="alt">
	<a href="javascript:void(0);" id="profile" class="profileLink">My Profile</a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:void(0);" id="passwd" class="profileLink">Change Password</a></h2>
	<div class="box" id="profileForm">
	<?php echo $this->Session->flash(); ?>
	
	<?php echo $this->Form->create('User');?>
		<label><span>Username</span>
			<?php echo $this->Form->text('username', array('class' => 'input-text', 'size' => 45, 'disabled' => 'disabled')); ?>
		</label>
		
		<label><span>E-mail</span>
			<?php echo $this->Form->text('email', array('class' => 'input-text', 'size' => 45)); ?>
		</label>
		
		<label><span>Firstname</span>
			<?php echo $this->Form->text('firstname', array('class' => 'input-text', 'size' => 45)); ?>
		</label>
			<label><span>Lastname</span>
			<?php echo $this->Form->text('lastname', array('class' => 'input-text', 'size' => 45)); ?>
		</label>
		<div style="clear: both;padding-bottom: 10px;"></div>

		
		<div style="clear: both;padding-bottom: 10px;"></div>
		<div class="spacer"><input type="submit" class="green" value="Save"></div>
	</form>
</div>

		
<div class="box" id="passwdForm" style="display:none;">
	<?php echo $this->Session->flash(); ?>
	
	<?php echo $this->Form->create('User', array('url' =>  '/users/change_password/' . $user_data['username']));?>
		<p>Change Your Password</p>
		<label><span>Current Password</span>
			<?php echo $this->Form->password('current_password', array('class' => 'input-text', 'size' => 45)); ?>
		</label>
		
		<label><span>Enter Your New Password</span>
			<?php echo $this->Form->password('new_password', array('class' => 'input-text', 'size' => 45)); ?>
		</label>
		
		<label><span>Please Repeat Your New Password</span>
			<?php echo $this->Form->password('repeat_password', array('class' => 'input-text', 'size' => 45)); ?>
		</label>
			
		<div style="clear: both;padding-bottom: 10px;"></div>

		
		<div style="clear: both;padding-bottom: 10px;"></div>
		<div class="spacer"><input type="submit" class="green" value="Save"></div>
	</form>
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