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
	
<script src="loadxml.js"></script>

<script>

       





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
			<div class="border">
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
					<div id="udsigt">
						<h1><?php echo $xml->channel->title; ?></h1>
						<h2><?php echo $xml->channel->item->title; ?></h2>
						<p><?php echo $xml->channel->item->description; ?></p>
					</div>

					
				</div>
				<div class="four columns">
						
					<h1>Radar</h1>
					<img src="http://www.dmi.dk/dmi/radar-animation640.gif">

					<h1>Aktuelle varsler</h1>
					<img src="http://www.dmi.dk/dmi/danmark/regionaludsigten/varsel_oversigt.png" />
					
					<h1>Beskriv vejret nær dig!</h1>
					<form action="post_comment.php" method="post">
						<ul>
							<li style="position: absolute; left: -9999999px;"><input type="text" name="comment_on" size=40 readonly="readonly" value="<?php print md5($_SERVER['PHP_SELF']); ?>" /></li>
							<li><input type="text" size=40 name="comment_by" placeholder="Navn" /></li>
							<li><textarea name="comment" cols=30 placeholder="Din beskrivelse"></textarea></li>
							<li class="buttons"><input type="submit" value="Indsend" /></li>
						</ul>
					</form>
					<?php
						/* U need to change below fields */
						$db_sitename="lokal_vejr";
						$db_hostname="localhost";
						$db_username="root";
						$db_password="root";
						$no_of_comments="6";
						 
						/* Leave the script below as it is */
						mysql_connect($db_hostname, $db_username, $db_password);
						mysql_select_db($db_sitename);
						$pagename=md5($_SERVER['PHP_SELF']);
						$query=mysql_query("Select * from comments where comment_on='$pagename' ORDER BY id DESC LIMIT 0, $no_of_comments");
						
						 
						echo "<h3>Seneste vejrbeskrivelser</h3>";
						while($fetch=mysql_fetch_array($query)) {
						echo "<p>".$fetch['comment']."<br/><sub><b>Comment by: </b>".$fetch['comment_by']."</sub><hr /><p>";
						}
						mysql_close();
					?>
				
				<script type="text/javascript">

				      if (navigator.geolocation) {

				        navigator.geolocation.getCurrentPosition(getInitialCoordinates);

				        // watch for changes in position


				      } else {

				        alert("Error: Your browser doesn't support geolocation.");

				      }

				       

				      function getInitialCoordinates(position) {

				 			

				 		var base = "http://maps.googleapis.com/maps/api/geocode/json?latlng=";
						var latlng = position.coords.latitude + "," + position.coords.longitude;
						var end = "&sensor=false";	 
				 		
				 		//alert(latlng);

				 		//xmlDoc=loadXML(base + latlng + end);

						//zip = xmlDoc.getElementsByTagName("results[0].address_component[7].long_name[0]");

						//alert(base + latlng + end);
				      }

						
					
				</script>


		
				
				</div>
		
			</div>
		</div>

	</div>

</body>
</html>