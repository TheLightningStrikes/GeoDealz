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
	<script type="text/javascript" src="<?php echo URL; ?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    
	<form id="form" class="center" action="<?php echo URL; ?>profiel/save" method="POST" enctype="multipart/form-data" >
		<div class="field">
			<label for="logo">Logo: </label>
			<input type="file" name="logo" id="filePhoto" />
		</div>
		<div class="field">
		<label for="">Preview: </label>
			<img id="previewHolder" src="<?php echo IMAGE_URL . $this->logo; ?>" width="200px" height="82px"/>
		</div>
		
		<div class="field">
            <label for="naam">Naam: </label>
            <input type="text" name="naam" value="<?php echo $this->naam; ?>" />
        </div>
		<div class="field">
            <label for="beschrijving">Beschrijving: </label>
            <textarea class="" name="beschrijving"><?php echo $this->beschrijving; ?></textarea>
        </div>
		<div class="field">
            <label for="opmerkingen">Opmerkingen: </label>
            <textarea class="" name="opmerkingen"><?php echo $this->opmerking; ?></textarea>
        </div>
		<input name="profiel_id" value="<?php echo $this->id; ?>" type="hidden" />
		<input name="image_url" value="<?php echo $this->logo; ?>" type="hidden" />
		
        <div class="field">
            <input class="blue" type="submit" value="Verzenden" />
        </div>
	</form>
	<div class="clearfix">
	</div>
</div>

