<script type="text/javascript">
	$(document).ready(function(){
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#previewHolder').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}
		$("#filePhoto").change(function() {
			readURL(this);
		});
	});
</script>	
<?php
if(isset($this->msg))
{	
	echo ShowMessage($this->msg);
}

?>
<div class="content light">
	<form id="form" class="center" action="<?php echo URL; ?>deals/save_date" enctype="multipart/form-data" method="POST">
		<div class="field">
            <label for="evenement">Evenement: </label>
            <select name="evenement">
				<?php 
				foreach($this->evenementen as $evenement)
				{
					echo "<option value=".$evenement['id'].">" . $evenement['naam'] . "</option>";
				}
				?>
			</select>
        </div>
		<div class="field">
            <label for="naam">Naam: </label>
            <input type="text" name="naam" value="" />
        </div>
		<div class="field">
			<label for="omschrijving">Omschrijving: </label>
			<textarea name="omschrijving"></textarea>
		</div>
		<div class="field">
			<label for="deal">Deal: </label>
			<input type="file" name="deal" id="filePhoto" />
		</div>
		<div class="field">
		<label for="">Preview: </label>
			
			<img id="previewHolder" src="<?php echo IMAGE_URL . $this->deal; ?>" />
		</div>
		
		<div class="field">
			<label for="deal">Start datum: </label>
			<input type="text" name="startdatum" id="startdate"  />
		</div>
		<div class="field">
			<label for="deal">Eind datum: </label>
			<input type="text" name="einddatum" id="enddate"  />
		</div>
		<div class="field">
            <input class="blue" type="submit" value="Verzenden" />
        </div>
		<input type="hidden" value="date" name="dealtype">
	</form>
	<div class="clearfix">
	</div>
</div>