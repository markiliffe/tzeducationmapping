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
          <input type="hidden" name="shule" />
            <input placeholder="Enter School Name or Number" type="text" autocomplete="off" name="tshule" onkeyup="bring()" >
            <input type="submit" />
            <div id="geocode-error"></div>
            
          </form>
        </div>
        <div id="dshule"></div>
        <div id="dfetch">
		<!---->
<?php

/* This PHP code fetches the school data from the database, using the identification number which
 * is selected from the school results table. This is selected by the 'schoolform' form.
 *
 * It is a future objective of NECTA to refactor this file into a separate file. 
 *
 */
	if(isset($_GET['shule']) && $_GET['shule']!='' )
	{
    $data='';
    require_once 'database_connection.php';
    $shule=trim($_GET['shule']);

    $sch=array("'",'"');
    $shule=str_replace($sch,"''", $shule);

    if($shule!=''){
      $q="SELECT * FROM tbl_school_results WHERE id=$shule";
    	$qone=mysql_query($q);
      while($rw=mysql_fetch_array($qone))
      {  
        $one=($rw['2011_percent_passed']==NULL)?0:$rw['2011_percent_passed'];
        $two=($rw['2012_percent_passed']==NULL)?0:$rw['2012_percent_passed'];
      
        $c2011=$rw['2011_clean'];
        $c2012=$rw['2012_clean'];
           
        $dr2011=$rw['2011_dist_rank'];
        $dr2012=$rw['2012_dist_rank'];
           
        $rr2011=$rw['2011_reg_rank'];
        $rr2012=$rw['2012_reg_rank'];
           
        $nr2011=$rw['2011_nat_rank'];
        $nr2012=$rw['2012_nat_rank'];
           
        $av2011=$rw['2011_av_mark'];
        $av2012=$rw['2012_av_mark'];
      }
    
      $data='Passed 2011,'.$one."\r\n".'Passed 2012,'.$two;
      $cn=explode('(',$_GET['tshule']);
      $c=explode(')',$cn[1]);
      	
      echo '<h4>School : '.strtoupper($cn[0]).' </h4>';
      echo '<BR /><b>Percent of Students passed 2011 and 2012</b> <BR /><BR />';
  }
?>
<div id="chart"></div>

<script>
    function renderChart() {

    var data = d3.csv.parse(d3.select('#csv').text());
    var valueLabelWidth = 40; // space reserved for value labels (right)
    var barHeight = 20; // height of one bar
    var barLabelWidth = 100; // space reserved for bar labels
    var barLabelPadding = 5; // padding between bar and bar labels (left)
    var gridLabelHeight = 18; // space reserved for gridline labels
    var gridChartOffset = 3; // space between start of grid and first bar
    var maxBarWidth = 420; // width of the bar with the max value
     
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
    <script id="csv" type="text/csv">YEAR,PERCENT PASSED
<?php echo $data; ?>
    </script>
    <script>renderChart();</script>


<table id="fdata">
   <tr><td>
    <h4>2011</h4>
    <BR /><b>School Number : <?php echo $c[0];?></b>
    <BR /><b>Students Enrolled for Examinations : <?php echo $c2011;?></b> 
    <BR /><b>District Rank : <?php echo $dr2011;?></b> 
    <BR /><b>Regional Rank : <?php echo $rr2011;?></b> 
    <BR /><b>National Rank : <?php echo $nr2011;?></b> 
    <BR /><b>Average Mark  : <?php echo $av2011;?></b> 
   </td><td>
    <h4>2012</h4>
    <BR /><b>School Number : <?php echo $c[0];?></b> 
    <BR /><b>Students Enrolled for Examinations : <?php echo $c2012; if($c2012>$c2011) echo ' <img src="ext/img/rise.png" />'; else if($c2012<$c2011) echo ' <img src="ext/img/drop.png" />';?></b> 
    <BR /><b>District Rank : <?php echo $dr2012; if($dr2012<$dr2011) echo ' <img src="ext/img/rise.png" />'; else if($dr2012>$dr2011) echo ' <img src="ext/img/drop.png" />';?></b> 
    <BR /><b>Regional Rank : <?php echo $rr2012; if($rr2012<$rr2011) echo ' <img src="ext/img/rise.png" />'; else if($rr2012>$rr2011) echo ' <img src="ext/img/drop.png" />';?></b> 
    <BR /><b>National Rank : <?php echo $nr2012; if($nr2012<$nr2011) echo ' <img src="ext/img/rise.png" />'; else if($nr2012>$nr2011) echo ' <img src="ext/img/drop.png" />';?></b> 
    <BR /><b>Average Mark : <?php echo $av2012; if($av2012>$av2011) echo ' <img src="ext/img/rise.png" />'; else if($av2012<$av2011) echo ' <img src="ext/img/drop.png" />';?> </b> 
  </td></tr>
</table>
<?php }?>

        </div>
      </div>
    </div>

    <!-- Layer switcher -->


    <div id="projects" class="layers" data-control="switcher">
      <a href="reset_map" data-zoom="6">Reset Map</a>
      <a href="primary_change" data-zoom="6">Primary Change, 2011 - 2012</a>
      <a href="#secondary_change" data-zoom="6">Secondary Change, 2011 - 2012</a

      <!-- Delete Here -->
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
