<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>NECTA Eductation Mapping</title>
    <link rel="stylesheet" href="http://api.tiles.mapbox.com/mapbox.js/v0.6.3/mapbox.css" type="text/css" />
    <link rel="stylesheet" href="ext/fonts/fonts.css" type="text/css" />
    <link rel="stylesheet" href="ext/css/style.css" type="text/css" />
    <link rel="stylesheet" href="ext/css/mapbox.share.css" type="text/css" />
    <link rel="shortcut icon" href="ext/img/favicon.ico" type="image/x-icon" />
    
    <script src='http://api.tiles.mapbox.com/mapbox.js/v0.6.3/mapbox.uncompressed.js'></script>
    <script src="ext/js/d3.v3.min.js"></script>
    <script src="ext/js/jquery.min.js"></script>
    <script src="ext/js/mapbox.jquery.js"></script>
    <script src="ext/js/mapbox.share.js"></script>
    <script src="ext/js/school_name_fetch.js"></script>
    <script src="ext/js/mapbox.jquery.geocoder.js"></script>

  </head>

  <!-- Here we use `data-map` to specify the id of the div the map is in -->
  <body data-map="map">
    <div id="content">

      <div id='branding'></div>
      <div id="about">
        <h1>Tanzanian Education Dashboard</h1>
        <!--<h1>Examination Results in Tanzania</h1>-->
        <!--<p>As part of the Government of Tanzania's "Big Results Now"</p>-->
        <!-- Geocoder -->
        <div data-control="geocode" id="search">
          <form name="schoolform" class="geocode">
          <input type="button" name="dshule" hidden />
          <input type="hidden" name="shule" />
            <input placeholder="Enter School Name or Number" type="text" autocomplete="off" name="tshule" onkeyup="bring()" >
            <input type="submit" />
            <div id="geocode-error"></div>
            
          </form>
        </div>
        <div id="dshule"></div>
        <div id="dfetch">
		<!---->

        </div>
        <script type='text/javascript'>
    function renderChart() {

    var data = d3.csv.parse(d3.select('#csv').text());
    var valueLabelWidth = 40; // space reserved for value labels (right)
    var barHeight = 20; // height of one bar
    var barLabelWidth = 100; // space reserved for bar labels
    var barLabelPadding = 5; // padding between bar and bar labels (left)
    var gridLabelHeight = 18; // space reserved for gridline labels
    var gridChartOffset = 3; // space between start of grid and first bar
    var maxBarWidth = 400; // width of the bar with the max value
     
    // accessor functions 
    var barLabel = function(d) { return d['YEAR']; };
    var barValue = function(d) { return parseFloat(d['PERCENT PASSED']); };
     
    // scales
    var yScale = d3.scale.ordinal().domain(d3.range(0, data.length)).rangeBands([0, data.length * barHeight]);
    var y = function(d, i) { return yScale(i); };
    var yText = function(d, i) { return y(d, i) + yScale.rangeBand() / 2; };
    var x = d3.scale.linear().domain([0, d3.max(data, barValue)]).range([0, maxBarWidth]);
    // svg container element
    var chart = d3.select('#chart').append("svg")
      .attr('width', maxBarWidth + barLabelWidth + valueLabelWidth)
      .attr('height', gridLabelHeight + gridChartOffset + data.length * barHeight);
    // grid line labels
    var gridContainer = chart.append('g')
      .attr('transform', 'translate(' + barLabelWidth + ',' + gridLabelHeight + ')'); 
    gridContainer.selectAll("text").data(x.ticks(10)).enter().append("text")
      .attr("x", x)
      .attr("dy", -3)
      .attr("text-anchor", "middle")
      .text(String);
    // vertical grid lines
    gridContainer.selectAll("line").data(x.ticks(10)).enter().append("line")
      .attr("x1", x)
      .attr("x2", x)
      .attr("y1", 0)
      .attr("y2", yScale.rangeExtent()[1] + gridChartOffset)
      .style("stroke", "#ccc");
    // bar labels
    var labelsContainer = chart.append('g')
      .attr('transform', 'translate(' + (barLabelWidth - barLabelPadding) + ',' + (gridLabelHeight + gridChartOffset) + ')'); 
    labelsContainer.selectAll('text').data(data).enter().append('text')
      .attr('y', yText)
      .attr('stroke', 'none')
      .attr('fill', 'black')
      .attr("dy", ".35em") // vertical-align: middle
      .attr('text-anchor', 'end')
      .text(barLabel);
    // bars
    var barsContainer = chart.append('g')
      .attr('transform', 'translate(' + barLabelWidth + ',' + (gridLabelHeight + gridChartOffset) + ')'); 
    barsContainer.selectAll("rect").data(data).enter().append("rect")
      .attr('y', y)
      .attr('height', yScale.rangeBand())
      .attr('width', function(d) { return x(barValue(d)); })
      .attr('stroke', 'white')
      .attr('fill', 'steelblue');
    // bar value labels
    barsContainer.selectAll("text").data(data).enter().append("text")
      .attr("x", function(d) { return x(barValue(d)); })
      .attr("y", yText)
      .attr("dx", 3) // padding-left
      .attr("dy", ".35em") // vertical-align: middle
      .attr("text-anchor", "start") // text-align: right
      .attr("fill", "black")
      .attr("stroke", "none")
      .text(function(d) { return d3.round(barValue(d), 2); });
    // start line
    barsContainer.append("line")
      .attr("y1", -gridChartOffset)
      .attr("y2", yScale.rangeExtent()[1] + gridChartOffset)
      .style("stroke", "#000");

    }
    </script>
      </div>
    </div>

    <!-- Layer switcher -->


    <div id="projects" class="layers" data-control="switcher">
      <a href="reset_map" data-zoom="6">Reset Map</a>
      <a href="primary_change" data-zoom="6">Primary Change, 2011 - 2012</a>
      <a href="#secondary_change" data-zoom="6">Secondary Change, 2011 - 2012</a

      ><!-- Delete Here -->
      <a href="secondary_locations" data-zoom"6">Primary Budget Spend</a>
      <a href="secondary_locations" data-zoom"6">Secondary Budget Spend </a>

    </div>


     <div id="location" class="layers" data-control="switcher"> 
      <a href="primary_locations" data-zoom="6">Primary Locations</a>
      <a href="secondary_locations" data-zoom"6">Secondary Locations</a>
      <!-- Delete Here -->
      <a href="secondary_locations" data-zoom"6">University Locations</a>
      
      <!--<a href="#primary_marks" data-zoom="6">Primary Marks 2012</a>-->
    </div>  

    <div id="map" class="map">
      <div class="map-legends">
        <div class="map-legend" style="display: block; ">
          <div class="scale">
            <!-- Insert a javascript object which works out the current map when selected and display the right legend -->
            <div><img src="ext/img/legend_exam_change_oneline.png" width="100%"/></div>
          </div> 
          <div>
        </div> 
        </div>
      </div>
    </div>

    <script src="ext/js/map_script.js"></script>
  </body>
</html>
