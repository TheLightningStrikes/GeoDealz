<?php
if(isset($this->msg))
{	
	echo ShowMessage($this->msg);
}
?>

<div class="content light">
	<div class="main">
		<div class="quick_acces">
			<a href="<?php echo URL ?>deals/new_normal">
				<div class="home_item">
					Nieuwe normale deal
				</div>
			</a>
			<a href="<?php echo URL ?>deals/new_date">
				<div class="home_item">
					Nieuwe datum deal
				</div>
			</a>
			<a href="<?php echo URL ?>deals/new_limited">
				<div class="home_item">
					Nieuwe limited deal
				</div>
			</a>
			<a href="<?php echo URL ?>deals/new_location">
				<div class="home_item">
					Nieuwe locatie deal
				</div>
			</a>
		</div>
		
	</div>
	<div class="clearfix">
	</div>
</div>