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
	<form id="form" class="center" action="<?php echo URL; ?>deals/update_limited" enctype="multipart/form-data" method="POST">
		<div class="field">
            <label for="naam">Naam: </label>
            <input type="text" name="naam" value="<?php echo $this->naam; ?>" />
        </div>	
		<div class="field">
			<label for="omschrijving">Omschrijving: </label>
			<textarea name="omschrijving"><?php echo $this->omschrijving; ?></textarea>
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
            <label for="naam">Amount: </label>
            <input type="text" name="limit" value="<?php echo $this->limit; ?>" id="limited"/>
        </div>		
		<input type="hidden" name="id" value="<?php echo $this->id; ?>">
		<input type="hidden" name="image_url" value="<?php echo $this->deal; ?>">
		<div class="field">
            <input class="blue" type="submit" value="Verzenden" />
        </div>
	</form>
	<div class="clearfix">
	</div>
</div>