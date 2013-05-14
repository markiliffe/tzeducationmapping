var TileJSONs = [
    'http://a.tiles.mapbox.com/v3/examples.map-20v6611k,mapbox.dc-property-values.jsonp',
    'http://a.tiles.mapbox.com/v3/markiliffe.Necta_Secondary_Percentage_Change_2011_2012.jsonp',
    'http://a.tiles.mapbox.com/v3/guyai.TZMAP.jsonp',

];

$('#map').mapbox(TileJSONs, function(map, tiledata) {

    // Assign readable names to all layers
    map.getLayerAt(0).named('base');
    map.getLayerAt(1).named('secondary_change');
    map.getLayerAt(2).named('primary_marks');


    // Don't composite base layer with other layers
    map.getLayer('base').composite(false);

    // Disable all overlay layers by default
    map.disableLayer('secondary_change');
    map.disableLayer('primary_marks');


    // Set initial latitude, longitude and zoom level
    map.setCenterZoom({
        lat: -8.7737,
        lon: 35.4199
    }, 6);

    // Set minimum and maximum zoom levels
    map.setZoomRange(0, 15);

    // Enable share control
    mapbox.share().map(map).add();

    //Enable tooltips?
    map.gridControl.options.follow = true;

    //Enable the legend
    map.legendControl.addLegend(document.getElementById('my-legend').innerHTML);


});
