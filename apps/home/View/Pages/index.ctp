<div class="box">
	<?php echo $this->Session->flash(); ?>
	<h1>Sign Up</h1>
	<p>New User? Create your account now!</p>
	<form action="/users/register" method="post">
		<label><span>Username</span>
			<input type="text" name="data[User][username]" id="name" class="input-text" size=45>
		</label>
		
		<label><span>E-mail</span>
			<input type="text" name="data[User][email]" id="email" class="input-text" size=45>
		</label>
		
		<label><span>Password</span>
			<input name="data[User][password]" type="password" id="psw" class="input-text" size=45>
		</label>
		<label><span>Repeat Password</span>
			<input name="data[User][repeat_password]" type="password" id="psw" class="input-text" size=45>
		</label>
		<div style="clear: both;padding-bottom: 10px;"></div>

		<label><span>Security Code </span>
			<div style="float:right";><?php echo $this->Solvemedia->solvemedia_get_html(SOLVEMEDIA_PUB_KEY); ?></div>
		</label>
		<div style="clear: both;padding-bottom: 10px;"></div>
		<div class="spacer"><input type="submit" class="green" value="Create Account"></div>
	</form>
</div>

