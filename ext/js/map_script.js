var TileJSONs = [
    'http://a.tiles.mapbox.com/v3/markiliffe.tz_education_blank.jsonp',
    'http://a.tiles.mapbox.com/v3/markiliffe.map-2yitmcy5.jsonp',
    'http://a.tiles.mapbox.com/v3/markiliffe.tzsecondaryschools.jsonp',
    'http://a.tiles.mapbox.com/v3/markiliffe.Necta_Secondary_Percentage_Change_2011_2012.jsonp',
    'http://a.tiles.mapbox.com/v3/markiliffe.Schools.jsonp',
    'http://a.tiles.mapbox.com/v3/markiliffe.tzprimaryexamchange11-12.jsonp',
   // 'http://a.tiles.mapbox.com/v3/guyai.TZMAP.jsonp',

];
 
$('#map').mapbox(TileJSONs, function(map, tiledata) {

    // Assign readable names to all layers
    map.getLayerAt(0).named('reset_map');
    map.getLayerAt(1).named('base');
    map.getLayerAt(2).named('secondary_locations');
    map.getLayerAt(3).named('secondary_change');
    map.getLayerAt(4).named('primary_locations');
    map.getLayerAt(5).named('primary_change');
    map.getLayerAt(6).named('primary_marks');

    // Don't composite base layer with other layers
    map.getLayer('base').composite(false);

    // Disable all overlay layers by default
    map.disableLayer('primary_marks');
    map.disableLayer('primary_change');
    map.disableLayer('primary_locations')
    map.disableLayer('secondary_locations');
    map.disableLayer('secondary_change');

    // Set initial latitude, longitude and zoom level
    map.setCenterZoom({
        lat: -8.7737,
        lon: 35.4199
    }, 6);

    // Set minimum and maximum zoom levels
    map.setZoomRange(0, 13);

    // Enable share control
    mapbox.share().map(map).add();


});
