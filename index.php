<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	
	<title>DMI.dk</title>
	
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600,700' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>	
    <script src="loadxml.js"></script>
    <script>
	    $(function() {
	        $( "#tabs" ).tabs();
	    });
    </script>
	<?php 
		$xml = simplexml_load_file("http://www.dmi.dk/dmi/kbh-udsigt.rss");
		$varsler = simplexml_load_file("http://www.dmi.dk/dmi/varsel.xml");
		$maps = simplexml_load_file("http://maps.googleapis.com/maps/api/geocode/xml?latlng=55.675649,12.528508&sensor=false");							
	 ?>


<script type="text/javascript">
$(function(){
   var GETZIP = {
      getLocation: function(){
         $('#status').text('searching...');
         if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(GETZIP.getZipCode, GETZIP.error, {timeout: 7000});//cache it for 10 minutes
         }else{
            GETZIP.error('Geo location not supported');
         }
      },
      index: 0,
      error: function(msg) {
         if(msg.code){
            //this is a geolocation error
            switch(msg.code){
            case 1:
               $("#status").text('Permission Denied').fadeOut().fadeIn();
               break;
            case 2:
               $("#status").text('Position Unavailable').fadeOut().fadeIn();
               break;
            case 3:
               GETZIP.index++;
               $("#status").text('Timeout... Trying again (' + GETZIP.index + ')').fadeOut().fadeIn();
               navigator.geolocation.getCurrentPosition(GETZIP.getZipCode, GETZIP.error, {timeout: 7000});
               break;
            default:
               //nothing
            }
         }else{
            //this is a text error
            $('#error').text(msg).addClass('failed');
         }
 
      },
 
      getZipCode: function(position){
         var position = position.coords.latitude + "," + position.coords.longitude;
         $.getJSON('proxy.php',{
            path : "http://maps.google.com/maps/api/geocode/json?latlng="+position+"&sensor=false",
            type: "application/json"
         }, function(json){
            //Find the zip code of the first result
            if(!(json.status == "OK")){
               GETZIP.error('Zip Code not Found');
               return;
            }
            var found = false;
            $(json.results[0].address_components).each(function(i, el){
               if($.inArray("postal_code", el.types) > -1){
                  $("#status").text('Your Zip Code: ' + el.short_name);
                  found = true;
                  return;
               }
            });
            if(!found){
               GETZIP.error('Zip Code not Found');
            }
         });
      }
   }
   GETZIP.getLocation();

});

</script>

</head>
<body>
	<div class="container">	
		<div class="header">
			<div id="logo"><img src="http://www.dmi.dk/dmi/dmi-logo.gif" alt="DMI"></div>
		</div>
		<div id="content" class="row">
			<div class="border">
				<div class="eight columns">
					<h1 id="status"></h1>
					<h1>Vejrudsigten nær dig!</h1>
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

							<script type="text/javascript">
							//	var dag3_9_base = '<img src="http://servlet.dmi.dk/byvejr/servlet/byvejr?by=';
							//	var dag3_9_end = '&tabel=dag3_9"';
							//	document.write(dag3_9_base + el.short_name + dag3_9_end);
								
							</script>
							<img src="http://servlet.dmi.dk/byvejr/servlet/byvejr?by=1000&tabel=dag3_9">
						</div>			
					</div>
					<div class="description eight columns">
						<div id="udsigt">
							<h1><?php echo $xml->channel->title; ?></h1>
						
							<h2><?php echo $xml->channel->item->title; ?></h2>
							<p style="height: 32px; overflow: hidden;"><?php echo $xml->channel->item->description; ?></p>
						</div>
					</div>
					<div class="three columns">
						<form>
							<input type="text" size="40" placeholder="Anden by" />
						</form>

					</div>
					<div id="links" style="clear: both;">
						<ul class="six columns">
							<li><a href="#"><img src="images/vejrkort.png">Verdenskort</a></li>
							<li><a href="#"><img src="images/Verden.png">Verdensvejr</a></li>
							<li><a href="#"><img src="images/Til-lands.png">Til Lands</a></li>
							<li><a href="#"><img src="images/til-sos.png">Til Søs</a></li>
							<li><a href="#"><img src="images/i-luften.png">I Luften</a></li>
							<li><a href="#"><img src="images/sundhedsvejr.png">Sundhedsvejr</a></li>
						</ul>
						<ul class="six columns">
							<li><a href="#"><img src="images/Tjenester.png">Tjenester</a></li>
							<li><a href="#"><img src="images/malinger.png">Målinger</a></li>
							<li><a href="#"><img src="images/viden.png">Viden</a></li>
							<li><a href="#"><img src="images/klima.png">Klima</a></li>
							<li><a href="#"><img src="images/Vejrarkiver.png">Arkiver</a></li>
							<li><a href="#"><img src="images/om-DMI.png">Om DMI</a></li>
						</ul>
					</div>
				</div>
				<div class="four columns">
						
					<h1>Radar</h1>
					<img src="http://www.dmi.dk/dmi/radar-animation640.gif">

					<h1>Aktuelle varsler</h1>
					<p><img src="http://www.dmi.dk/dmi/danmark/regionaludsigten/varsel_oversigt.png" /></p>
					
					<h1>Beskriv vejret nær dig!</h1>
					<form action="post_comment.php" method="post">
						<ul>
							<li style="position: absolute; left: -9999999px;"><input type="text" name="comment_on" size=40 readonly="readonly" value="<?php print md5($_SERVER['PHP_SELF']); ?>" /></li>
							<li><input type="text" size=40 name="comment_by" placeholder="Navn" required="required"/></li>
							<li><textarea name="comment" cols=30 placeholder="Din beskrivelse" required="required"></textarea></li>
							<li class="buttons"><input type="submit" value="Indsend" /></li>
						</ul>
					</form>
					<?php
						include 'dbinfo.php';
						mysql_connect($db_hostname, $db_username, $db_password);
						mysql_select_db($db_sitename);
						$pagename=md5($_SERVER['PHP_SELF']);
						$query=mysql_query("Select * from comments where comment_on='$pagename' ORDER BY id DESC LIMIT 0, $no_of_comments");
						echo "<h3>Seneste vejrbeskrivelser</h3>";
						while($fetch=mysql_fetch_array($query)) {
						echo "<p>".$fetch['comment']."<br/><sub><b>Skrevet af: </b>".$fetch['comment_by']."</sub><hr /><p>";
						}
						mysql_close();
					?>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
	</div>
<<<<<<< HEAD
	<script type="text/javascript">
		if (navigator.geolocation) {
	        	navigator.geolocation.getCurrentPosition(getInitialCoordinates);
	        } else {
		        alert("Error: Your browser doesn't support geolocation.");
	    	}	

	    	function loadXML(dname)
			{
				if (window.XMLHttpRequest)
				  {
				  xhttp=new XMLHttpRequest();
				  }
				else
				  {
				  xhttp=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				xhttp.open("GET",dname,false);
				xhttp.send();
				return xhttp.responseXML;
}			    
		    function getInitialCoordinates(position) {	

		    /*	var proxybase = "localhost/proxy.php?proxy_url="		 			
		 		var base = "http://maps.googleapis.com/maps/api/geocode/xml?latlng=";
				var latlng = position.coords.latitude + "," + position.coords.longitude;
				var end = "&sensor=false";	*/


				
				var xmlresp = loadXML("proxy.php?proxy_url=http://maps.googleapis.com/maps/api/geocode/xml?latlng=55.675649,12.528508&sensor=false");
				
			
				alert(xmlresp.getElementsByTagName("result[0].address_component[7].long_name[0]"));
=======
>>>>>>> asdasd
	
		 

</body>
</html>