<ul id="nav">

	<?php if(!empty($user_data)) : ?>
		<li><a href="/home">Home</a></li>
		<li><a href="/users/profile/<?php echo $user_data['username']; ?>">My Account</a></li>
		<li><a href="#form" id="formadd">Add New</a></li>
	<?php else : ?>
		<li><a href="/">Home</a></li>
		<li><a href="/pages/about">About Nyimpen</a></li>
	<?php endif; ?>

</ul>
<?php /*

	if(empty($user_data))
		echo $this->Facebook->login(array('perms' => 'email,publish_stream')); 
	else
		echo $this->Facebook->logout(); */
?>
<div id="formLogin">
	<?php if(!empty($user_data)) : ?>
		<a class="logout alt" href="/users/logout">Sign Out</a>
	<?php else : ?>
		<form method="post" action="/users/login" class="login-form">
		  <input id="username" type="text" name="data[User][username]" value="username" >  
		  <input id ="password" type="password" name="data[User][password]" value="password" >   
		  <input type="submit" value="Log in" name="login" id="login" class="green">
		</form>
	<?php endif; ?>
</div>

<?php /*
<div class = "logout">
<?php echo $this->Facebook->logout(array('redirect' => '/users/logout', 'label' => 'Sign Out')); ?>
</div> */ ?>

