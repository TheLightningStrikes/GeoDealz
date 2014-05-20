 <div class="content light">
	<script type="text/javascript" src="<?php echo URL; ?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <form id="form" class="center" action="<?php echo URL; ?>content/update" method="POST">
        <div class="field">
            <label for="naam">Title: </label>
            <input type="text" name="title" value="<?php echo $this->content[0]['title']; ?>" />
        </div>
        <div class="field WYSIWYG">
            <label for="content">Content: </label>
            <textarea class="WYSIWYG" name="content"><?php echo $this->content[0]['content']?></textarea>
        </div>
		<div class="field">
            <label for="visible">Is zichtbaar: </label>
            <input type="checkbox" name="visible" value="1" <?php echo (($this->content[0]['visible'] == "1")?"checked":""); ?> />
        </div>
        <div class="field">
            <input class="blue" type="submit" value="Verzenden" />
        </div>
        <input type="hidden" name="content_id" value="<?php echo $this->content[0]['id']; ?>" />
    </form>
    <script type="text/javascript">
        tinymce.init({
			
			selector: "textarea",
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table contextmenu paste jbimages"
			],
			toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | table | bullist numlist outdent indent | link jbimages | code ",
			autosave_ask_before_unload: false,
			menubar:false,
			relative_urls: false
		});	
    </script>
	<div class="clearfix">
	</div>
 </div>