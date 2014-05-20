<?php
function ShowMessage($message)
{
	$output = 	"<script type=\"text/javascript\">
					function HideMessage()
					{
						var element = document.getElementById(\"message\");
						element.setAttribute(\"Style\", \"Display: none;\");            				
					}
				</script>";

	$output .=  "<div id=\"message\" onclick=\"HideMessage()\">
					<div class=\"text\">
						<p>$message</p>
					</div>
				</div>";
	return $output;
}