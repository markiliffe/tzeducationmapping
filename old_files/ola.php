
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- Generated with d3-generator.com -->
<html>
  <head>
     <link href="main.css" rel="stylesheet" type="text/css" />
<title>BRN</title>
     <meta http-equiv="X-UA-Compatible" content="IE=9">
  </head>
  <body>
    
    <script src="d3/d3.v3.min.js"></script>
<script type="text/javascript">

function httpreq()
{
	var ajaxRequest; 
	try{
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				alert("Browser Error!");
				return false;
			}
		}
	}
	return ajaxRequest;
	}

function bring(a){
mpunga=document.fsch.tshule.value;

//begin
	var ajx = httpreq();
	if(ajx==false)return false;
	
	ajx.onreadystatechange = function(){
		if(ajx.readyState == 4){
					   document.getElementById('dshule').innerHTML = ajx.responseText;
		}
	}

	ajx.open("GET", "bring.php?l="+mpunga, true);
	
	
	
	ajx.send(null);
}
function weka(id,mpg)
{ 
document.fsch.shule.value=id;
document.fsch.tshule.value=mpg;
document.getElementById('dshule').innerHTML = '';
}
function ondoa()
{
document.getElementById('dshule').innerHTML = '';
}
</script>

<table align="center" width="700">
<tr><td colspan="2">
<div id="sech">
<form name="fsch" action="" method="post">
<input type="hidden" name="shule" />
<input class="cent" type="text" autocomplete="off" name="tshule" onkeyup="bring()"  />
<input id="sub" type="submit" name="sub" value="" /><br>
<div id="dshule"></div>
</form>

</div>
</td></tr>
<tr><td colspan="2">
<?PHP
if(isset($_POST['sub']))
{
$data='';

require_once 'conn.php';
$shule=trim($_POST['shule']);

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
}

 $data='Passed 2011,'.$one."\r\n".'Passed 2012,'.$two;
 $cn=explode('(',$_POST['tshule']);
  $c=explode(')',$cn[1]);
	
echo '<BR /><h4>School : '.strtoupper($cn[0]).' </h4><BR />';
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

<BR /><BR /><BR /><BR />
</td></tr>
<tr><td>
<BR /><h4>2011</h4>
<BR /><b>School Number : <?php echo $c[0];?></b> <BR />
<BR /><b>Students Enrolled for Examinations : <?php echo $c2011;?></b> <BR />
<BR /><b>National Rank</b> <BR />

</td><td>
<BR /><h4>2012</h4>
<BR /><b>School Number : <?php echo $c[0];?></b> <BR />
<BR /><b>Students Enrolled for Examinations : <?php echo $c2012; if($c2012>$c2011) echo ' <img src="img/rise.png" />'; else echo ' <img src="img/drop.png" />';?></b> <BR />
<BR /><b>National Rank</b> <BR />
<?PHP }?>
</td></tr>
</table>
</body>
</html>