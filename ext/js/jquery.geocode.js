!function($) {

    $.fn.geocode = geocode;

    function geocode(e) {

        e.preventDefault();
        var $this = $(this),
            map = $('#' + $this.parents('[data-map]').data('map')).data('map'),
            query = encodeURIComponent($this.find('input[type=text]').val());
          
      
      var geocodes=L.mapbox.geocoder("http://a.tiles.mapbox.com/v3/markiliffe.Schools.jsonp");
      alert(geocodes.query(query));
  }
    $(function() {
        $('[data-control="geocode"] form').submit(geocode);
    });

}(window.jQuery);
