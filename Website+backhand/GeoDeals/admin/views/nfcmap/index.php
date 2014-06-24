<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
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
	
	var map;
	var markersArray = [];
	var marker_location;
	var locationArray = [];
	
	function initMap()
	{
		var latlng = new google.maps.LatLng(52, 5);
		var myOptions = {
			zoom: 10,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		
		
		<?php
			foreach($this->markers as $marker)
			{
				if(!empty($marker['x']) && !empty($marker['y']))
				{
		?>
					var edit_marker = new google.maps.LatLng(<?php echo $marker['x']; ?>, <?php echo $marker['y']; ?>);
					placeMarker(edit_marker);	
		<?php 
				}
			} 
		?>
		
		// add a click event handler to the map object
		google.maps.event.addListener(map, "click", function(event)
		{
			// place a marker
			placeMarker(event.latLng);
				
			var data = JSON.stringify(locationArray)
			$('#markers').attr('value' , data);
		});
	}
	
	function placeMarker(location) {
		// first remove all markers if there are any
		//deleteOverlays();

		var marker = new google.maps.Marker({
			position: location, 
			map: map
		});
		markersArray.push(marker);
	    locationArray.push(location);
		
		google.maps.event.addListener(marker, "rightclick", function (event)
		{		
			var id = markersArray.indexOf(marker);
			var delMarker = markersArray[id];
			
			markersArray.splice(id, 1);
			locationArray.splice(id, 1);
			
			var data = JSON.stringify(locationArray)
			$('#markers').attr('value' , data);
			delMarker.setMap(null);
		});
	}
	google.maps.event.addDomListener(window, 'load', initMap);	
</script>
<?php
if(isset($this->msg))
{	
	echo ShowMessage($this->msg);
}

?>
<div class="content light">
	<form id="form" class="center" action="<?php echo URL; ?>nfcmap/update" enctype="multipart/form-data" method="POST">
		<div class="field wide">
			<label for="map">Plaats markers op de kaart waar nfc tags zich bevinden. Om de </label>
			<div id="map_canvas"></div>
		</div>
		<div class="field wide">
            <input class="blue" type="submit" value="Verzenden" />
        </div>
		<input type="hidden" value="" name="markers" id="markers" />
	</form>
	<div class="clearfix">
	</div>
</div>