<div class="content light">
	<div class="global blue"><span>Gemiddelde score over alle deals: <?php echo substr($this->global_rating, 0, 3); ?></span></div>
	<?php 
		foreach($this->ratings as $rating)
		{
			?>
			
			<div class="rating blue">
				<div class="rate">
				<h3><?php echo $rating['naam']; ?></h3>
				
					<p>Gemiddelde rating van: <?php echo substr($rating['avg'], 0, 3); ?></p>
				</div>
			</div>
			<?php
		}
	?>
	<div style="clear: both;"></div>
</div>