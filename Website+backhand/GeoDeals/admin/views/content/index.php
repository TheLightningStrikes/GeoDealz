 <div class="content light">
	<form id="form" action="content/new">
		<input style="color: white;" type="submit" value="Nieuw" />
	</form>
	<table>
		<caption class="blue"><h3>Pagina's</h3></caption>
		<thead>
		<?php
		if(count($this->data) > 0){
		?>
			<th class="name">Name</th>
			<th class="edit">Edit</th>
			<th class="delete">Delete</th>
			<th class="visible">Is zichtbaar</th>
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
						echo '<td class="name">' . $data['title'] . '</td>';		
						echo '<td><a href=content/edit/'. $data['id'] . '>Edit</a></td>';	
						echo '<td><a href=content/delete/' . $data['id'] . '>Delete</a></td>';	
						echo '<td class="visible">' . (($data['visible'] == 1)? '<img src="'. URL .'images/accept.png" />'  : '<img src="'. URL .'images/delete.png" />') .  '</td>';	
			
					echo '</tr>';
				
			}
		?>
		</tbody>
	</table>	
 </div>