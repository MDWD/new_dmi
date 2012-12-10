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