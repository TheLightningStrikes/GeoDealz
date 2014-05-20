  <div class="content light">
	<script type="text/javascript" src="<?php echo URL; ?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <form id="form" class="center" action="<?php echo URL; ?>content/save" method="POST">
        <div class="field">
            <label for="naam">Title: </label>
            <input type="text" name="title" value="" />
        </div>
        <div class="field WYSIWYG">
            <label for="content">Content: </label>
            <textarea class="WYSIWYG" name="content"></textarea>
        </div>
		<div class="field visible">
            <label for="visible">Is zichtbaar: </label>
            <input type="checkbox" name="visible" value="1" />
        </div>
        <div class="field">
            <input class="blue" type="submit" value="Verzenden" />
        </div>
    </form>
    <script type="text/javascript">
		tinymce.init({
			
			selector: "textarea",
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table contextmenu paste jbimages"
			],
			toolbar: "insertfile | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link jbimages | code",
			autosave_ask_before_unload: false,
			menubar:false,
			relative_urls: false
		});	
    </script>
	<div class="clearfix">
	</div>
 </div>