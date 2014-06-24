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
	
	$( "form" ).submit(function( event ) {
			
			alert("Hi");
			event.preventDefault();
		});	
	
        var map;
        var markersArray = [];
		var marker_location;
        function initMap()
        {
            var latlng = new google.maps.LatLng(52, 5);
            var myOptions = {
                zoom: 10,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            // add a click event handler to the map object
            google.maps.event.addListener(map, "click", function(event)
            {
                // place a marker
                placeMarker(event.latLng);
				
            });
        }
        function placeMarker(location) {
            // first remove all markers if there are any
            deleteOverlays();

            var marker = new google.maps.Marker({
                position: location, 
                map: map
            });
			
			marker_location = location;
			
            // add marker in markers array
            markersArray.push(marker);
			$('.location')
					.attr('value', marker_location);
            //map.setCenter(location);
        }

        // Deletes all markers in the array by removing references to them
        function deleteOverlays() {
            if (markersArray) {
                for (i in markersArray) {
                    markersArray[i].setMap(null);
                }
            markersArray.length = 0;
            }
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
	<form id="form" class="center" action="<?php echo URL; ?>deals/save_location" enctype="multipart/form-data" method="POST">
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
		<div class="field wide">
			<label for="">Preview: </label>
			<img id="previewHolder" src="<?php echo IMAGE_URL . $this->deal; ?>" />
		</div>
		<div class="field wide">
			<label for="map">Map:</label>
			<div id="map_canvas"></div>
		</div>
		
		<input type="hidden" value="" name="location" class="location">
		<input type="hidden" value="location" name="dealtype">
		<div class="field">
            <input class="blue" type="submit" value="Verzenden" />
        </div>
	</form>
	<div class="clearfix">
	</div>
</div>