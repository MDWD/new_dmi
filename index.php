<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	
	<title>DMI.dk</title>
	
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600,700' rel='stylesheet' type='text/css'>
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

    <script>
	    $(function() {
	        $( "#tabs" ).tabs();
	    });
    </script>
	<?php 

		$xml = simplexml_load_file("http://www.dmi.dk/dmi/kbh-udsigt.rss");
		$varsler = simplexml_load_file("http://www.dmi.dk/dmi/varsel.xml");
		$maps = simplexml_load_file("http://maps.googleapis.com/maps/api/geocode/xml?latlng=55.686391,12.5321132&sensor=false");
	 ?>
	
<script>

       

      if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(getInitialCoordinates, trapError);

        // watch for changes in position

        navigator.geolocation.watchPosition(updateCoordinates);

      } else {

        alert("Error: Your browser doesn't support geolocation.");

      }

       

      function getInitialCoordinates(position) {

document.write("Initial Coordinates:\n" + "latitude = " +  position.coords.latitude + "\nlongiture= " + position.coords.longitude);

      }

 

 function updateCoordinates(position) {

// hanlde coorfinate updates

      }

       

      function trapError() {

          alert("Error: The Geolocation service failed.");

 }

    </script>


</head>
<body>
	<div class="container">
		
		<heading class="header">
			<div id="logo"><img src="http://www.dmi.dk/dmi/dmi-logo.gif" alt="DMI"></div>
		</heading>

		<div id="content" class="row">
			<div class="eight columns">
				<h1>Vejret nu og her</h1>
				<div id="tabs">
					<ul>
						<li><a href="#tabs-1"><h2>Time for time</h2></a></li>
						<li><a href="#tabs-2"><h2>3-9 døgns udsigt</h2></a></li>
						<div style="clear:both;"></div>
					</ul>
					<div id="tabs-1">
						<img src="http://servlet.dmi.dk/byvejr/servlet/byvejr_dag1?by=<?php echo $maps->result->address_component[7]->long_name; ?>&mode=long">
					</div>
					<div id="tabs-2">
						<img src="http://servlet.dmi.dk/byvejr/servlet/byvejr?by=1000&tabel=dag3_9">
					</div>
					
				</div>

				<h1><?php echo $xml->channel->title; ?></h1>
				<h2><?php echo $xml->channel->item->title; ?></h2>
				<p><?php echo $xml->channel->item->description; ?></p>
				

			</div>
			<div class="four columns">
					
				<h1>Radar</h1>
				<img src="http://www.dmi.dk/dmi/radar-animation640.gif">

				<h1>Aktuelle varsler</h1>
				<p><?php echo $varsler->channel->item->description; ?></p>
				<h1></h1>
			
			</div>
		</div>

	</div>

</body>
</html>