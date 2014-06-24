<?php
if(isset($this->msg))
{	
	echo ShowMessage($this->msg);
}
?>

<div class="content light">
	<div class="main">
		<table>
			<caption class="blue"><h3>Deals</h3></caption>
			<thead >
			<?php
			if(count($this->data) > 0){
			?>
				<tr class="odd">
					<th class="name">Name</th>
					<th class="actions">Approve</th>
					<th class="actions">Deny</th>
				</tr>
			<?php
			}
			?>
			</thead>
			<tbody>
				<?php
				$count = 0;
			
				foreach($this->data as $data)
				{
					$class= (++$count%2 ? "even" : "odd");
				
					echo '<tr class=' . $class. '>';
						echo "<td class='name'>" . $data['naam'] . "</td>";
						echo "<td class='actions'><a class='button' href='deals/approve/". $data['id']."'>Approve</a></td>";
						echo "<td class='actions'><a class='button' href='deals/deny/". $data['id']."'>Deny</a></td>";
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="clearfix">
	</div>
</div>