<div class="content light">
	<form id="form" class="center" action="<?php echo URL; ?>deals/save" method="POST">
		<div class="field">
            <label for="logo">Logo: </label>
            <textarea class="" name="logo"></textarea>
        </div>
		<div class="field">
            <label for="titel">Titel: </label>
            <input type="text" name="titel" value="" />
        </div>
		<div class="field">
            <label for="ondertitel">Ondertitel: </label>
            <textarea class="" name="ondertitel"></textarea>
        </div>
		<div class="field">
            <input class="blue" type="submit" value="Verzenden" />
        </div>
	</form>
	<div class="clearfix">
	</div>
</div>