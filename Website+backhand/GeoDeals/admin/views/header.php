<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>
			CMS Geodeals
		</title>
			<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
			<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
			<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
			
			<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
			<!--styles-->
			<link rel="stylesheet" href="<?php echo URL; ?>views/resources/style.css" />
			<link rel="stylesheet" href="<?php echo URL; ?>views/resources/color.css" />
			<link rel="stylesheet" href="<?php echo URL; ?>views/resources/form.css" />
			<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  
			<!--scripts-->
			<script type="text/javascript" src="<?php echo URL; ?>tinymce/tinymce.min.js"></script>
			<script type="text/javascript" src="<?php echo URL; ?>javascript/form.js"></script>
			<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
			
			<script>
			$(function() {
				$( "#startdate" ).datepicker();
				$( "#enddate" ).datepicker();
				$("#limited").spinner();
			});
			</script>
	</head>
	<body>
		<div id="wrapper">
		