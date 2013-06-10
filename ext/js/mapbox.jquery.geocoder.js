!function($) {

    $.fn.geocode = geocode;

    function geocode(e) {

        e.preventDefault();
        var $this = $(this),
            map = $('#' + $this.parents('[data-map]').data('map')).data('map'),
            query = $this.find('input[type=text]').val();
        var qr=query.split("(");
        var shuleid=$this.find('input[type=hidden]').val();
        var q=encodeURIComponent($this.find('input[type=button]').val());
            //query="dar-es-salaam";
           
       getGeoCode(encodeURIComponent(qr[0].trim()),successes,$this);

      

        function successes(resp) {
            resp = resp[0];
         
            $this.removeClass('loading');

            if (!resp) {
                 getGeoCode(q,successes,$this);
                $this.find('#geocode-error').text('This address cannot be found.').fadeIn('fast');
                console.log(resp);
              
               // return;
            }

            $this.find('#geocode-error').hide();

            map.setExtent([
                { lat: resp.boundingbox[1], lon: resp.boundingbox[2] },
                { lat: resp.boundingbox[0], lon: resp.boundingbox[3] }
            ]);

            if (!map.getLayer('geocode')) {
                var layer = mapbox.markers.layer().named('geocode');
                map.addLayer(layer);
                layer.tilejson = function() { return {
                    attribution: 'Search by <a href="http://developer.mapquest.com/web/products/open">MapQuest Open</a>'
                }};
            }

            map.getLayer('geocode').features([]).add_feature({
                'type': 'Feature',
                'geometry': { 'type': 'Point', 'coordinates': [resp.lon, resp.lat] },
                'properties': {}
            });


            map.ui.refresh(); // Update attribution
        }
     getData("school_fetcher.php?shule="+shuleid+"&tshule="+query);
        
    }

    $(function() {
        $('[data-control="geocode"] form').submit(geocode);
      
    });

}(window.jQuery);

function getGeoCode(query,callfunc,$this){
    $.ajax({
           type: 'get',
           dataType:"jsonp",
            jsonpCallback: 'callback',
            jsonpCallbackName: 'callback',
            url: "http://open.mapquestapi.com/nominatim/v1/search?format=json&json_callback=callback&limit=1&countrycodes=TZ&q="+query,
            beforeSend:function(){
              //  alert("start sending");
              $this.addClass('loading');
            }, 
            success:callfunc,
            error:function(error){
              
                //alert("error occured"+error);
            }
        }); 
}

function getData(urls){
    $.ajax({
    dataType:"html",
    type:"get",
    url: urls,
    success:function(response){
    document.getElementById('dfetch').innerHTML = response; 
    }
    });
}
