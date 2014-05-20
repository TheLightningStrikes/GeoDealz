<div class="top dark">
	<div class="container">
	</div>
	
	<?php
Session::init();

if(Session::get("isLoggedIn"))
{
	echo "<form id=\"form\" action=\"" . URL . "login\logout\">
			<input style=\"color: white;\"type=\"submit\" value=\"Logout\" />
	</form>";
}
if(User::isAuthenticated(1))
{
?>
<ul class="menu">
		<li>
			<a href="<?php echo URL ?>index">Home</a>
		</li>
		<li>
			<a href="<?php echo URL ?>deals">Deals</a>
		</li>
		<li>
			<a href="<?php echo URL ?>profiel">Profiel</a>
		</li>
		<li style=" display: none; float: right">
			<a href="<?php echo URL ?>instellingen/index">Instellingen</a>
		</li>
	</ul>
	<div style="clear: both;"></div>
<?php 
}
?>
</div>
