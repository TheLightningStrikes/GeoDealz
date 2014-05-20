<div class="content light">
	<script type="text/javascript" src="<?php echo URL; ?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    
	<form id="form" class="center" action="<?php echo URL; ?>createDeal/save" method="POST">
		<div class="field">
            <label for="dealnaam">Deal naam: </label>
            <input type="text" name="dealnaam" value="<?php echo $this->dealnaam; ?>" />
        </div>
		<div class="field">
            <label for="actie">Actie: </label>
            <input type="text" name="actie" value="<?php echo $this->actie; ?>" />
        </div>
		<div class="field">
            <label for="Opmerkingen">Opmerkingen: </label>
            <textarea class="" name="opmerkingen"><?php echo $this->opmerkingen; ?></textarea>
        </div>
		<div class="field">
		<form action="upload_file.php" method="post" enctype="multipart/form-data">
			<label for="logo">Logo:</label>
			<input type="file" name="logo" id="file"><?php echo $this->logo; ?></input>
		</form>
		</div>
        <div class="field">
            <input class="blue" type="submit" value="Verzenden" />
        </div>
	</form>
	<div class="clearfix">
	</div>
</div>