<div class="content light">
	<script type="text/javascript" src="<?php echo URL; ?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	
	<div class="new_buttons">
		<form id="form" class="" action="<?php echo URL; ?>deals/new_normal" method="POST">
			<input class="blue" type="submit" value="Nieuw normal deal" />
		</form>
		<form id="form" class="" action="<?php echo URL; ?>deals/new_date" method="POST">
			<input class="blue" type="submit" value="Nieuw datum deal" />
		</form>
		<form id="form" class="" action="<?php echo URL; ?>deals/new_limited" method="POST">
			<input class="blue" type="submit" value="Nieuw limited deal" />
		</form>
		<form id="form" class="" action="<?php echo URL; ?>deals/new_location" method="POST">
			<input class="blue" type="submit" value="Nieuw location deal" />
		</form>
	</div>
	
	
	<table>
		<caption class="blue"><h3>Deals</h3></caption>
		<thead>
		<?php
		if(count($this->data) > 0){
		?>
			<th class="image">Deal</th>
			<th class="name">Name</th>
			<th class="type">Type</th>
			<th class="edit">Edit</th>
			<th class="delete">Delete</th>
			<!--<th class="visible">Is zichtbaar</th>-->
		<?php
		}
		?>
		</thead>
		<tbody>
		<?php
			$count = 0;
		
				foreach($this->data as $data)
				{
					$class= (++$count%2 ? "odd" : "even");
				
					echo '<tr class=' . $class. '>';
						echo '<td class="image"><img src="'.IMAGE_URL . $data['deal']  .'" width="100" /></td>';
						echo '<td class="name">' . $data['naam'] . '</td>';		
						
						$type = "Normaal";
						switch($data['type'])
						{
							case "date":
								$type = "Datum";
							break;
							case "limited":
								$type = "Limited";
								break;
							case "location":
								$type="Location";
							break;
						}
						echo '<td class="type">'.$type.'</td>';	
						
						switch($data['type'])
						{
							case "normal":
								echo '<td><a href=deals/edit/'. $data['id'] . '>Edit</a></td>';	
							break;
							case "date":
								echo '<td><a href=deals/edit_date/'. $data['id'] . '>Edit</a></td>';	
							break;
							case "limited":
								echo '<td><a href=deals/edit_limited/'. $data['id'] . '>Edit</a></td>';	
							break;
							case "location":
								echo '<td><a href=deals/edit_location/'. $data['id'] . '>Edit</a></td>';	
							break;
						}
						
						
						echo '<td><a href=deals/delete/' . $data['id'] . '>Delete</a></td>';	
						/*echo '<td class="visible">' . (($data['visible'] == 1)? '<img src="'. URL .'images/accept.png" />'  : '<img src="'. URL .'images/delete.png" />') .  '</td>';	*/
			
					echo '</tr>';
				
			}
		?>
		</tbody>
	</table>
	
	<div class="clearfix">
	</div>
</div>