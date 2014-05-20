<?php
if(isset($this->msg))
{	
	echo ShowMessage($this->msg);
}

?>
<div class="content light">
	<div class="login">
		<form id="form" action="<?php echo URL; ?>login/checklogin" method="POST">
			<div class="field">
				<label for="username">Gebruikersnaam:</label>
				<input type="text" name="username" />
			</div>
			<div class="field">
				<label for="password">Wachtwoord:</label>
				<input type="password" name="password" />
			</div>
			<div class="field">
				<input class="blue" type="submit" name="Login" value="Login"/>
			</div>
		</form>
		<div class="clearfix">
		</div>
	</div>
</div>
