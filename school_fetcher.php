<?php

/* This PHP code fetches the school data from the database, using the identification number which
 * is selected from the school results table. This is selected by the 'schoolform' form.
 *
 * It is a future objective of NECTA to refactor this file into a separate file. 
 *
 */
 function fetch_district($district_id){
    $district_data="";
    $q="select tbl_region_id,dist_name from tbl_districts where id='".$district_id."'";
    $result=@mysql_query($q);
    if(@mysql_num_rows($result)>0){
      $dist=@mysql_fetch_array($result);
      $district_data=array($dist['tbl_region_id'],$dist['dist_name']);
    }
    return $district_data;
  }

  function fetch_region($region_id){
  $region_data="";
    $q="select reg_no,reg_name from tbl_region where id='".$region_id."'";
    $result=@mysql_query($q);
    if(@mysql_num_rows($result)>0){
      $reg=@mysql_fetch_array($result);
      $region_data=array($reg['reg_no'],$reg['reg_name']);
    }
    return $region_data;  
  }
  
	if(isset($_GET['shule']) && $_GET['shule']!='' )
	{
    $data='';
    require_once 'database_connection.php';
    $shule=trim($_GET['shule']);

    $sch=array("'",'"');
    $shule=str_replace($sch,"''", $shule);

    if($shule!=''){
      $region="";
      $district="";
      $q="SELECT * FROM tbl_sec_school_results WHERE id='".$shule."'";
    	$qone=mysql_query($q);
      while($rw=mysql_fetch_array($qone))
      {  
        $one=($rw['2011_passed']==NULL)?0:$rw['2011_passed'];
        $two=($rw['2012_passed']==NULL)?0:$rw['2012_passed'];
      
        $c2011=$rw['2011_clean'];
        $c2012=$rw['2012_clean'];
           
        $dr2011=$rw['2011_dist_rank'];
        $dr2012=$rw['2012_dist_rank'];
           
        $rr2011=$rw['2011_reg_rank'];
        $rr2012=$rw['2012_reg_rank'];
           
        $nr2011=$rw['2011_nat_rank'];
        $nr2012=$rw['2012_nat_rank'];
           
        $av2011=$rw['2011_avGPA'];
        $av2012=$rw['2012_avGPA'];
        $secdistrict=$rw['district'];
        $secregion=$rw['region'];
        //$district=fetch_district($rw['tbl_districts_id']);

        //if(is_array($district)){
        //$region=fetch_region($district[0]);
     // }

      }
    
      $data='Passed 2011,'.$one."\r\n".'Passed 2012,'.$two;
      $cn=explode('(',$_GET['tshule']);
      $c=explode(')',$cn[1]);
      //$myregion=is_array($region)?$region[1]:"";
      //$mydistrict=is_array($district)?$district[1]:"";
      echo '<h4>School : '.strtoupper($cn[0]).' </h4>';
      echo '<h4>Region :'.$secregion.' </h4>';
      echo '<h4>District:'.$secdistrict.'</h4>';
      echo '<BR /><b>Percent of Students passed 2011 and 2012</b> <BR /><BR />';
  }

  
?>
<?php echo '<div id="chart"></div>' ; ?>
<?php 
$chartscript =<<<STARTSCRIPT

  
STARTSCRIPT;
echo $chartscript;
    ?>
<?php echo '<script id="csv" type="text/csv">YEAR,PERCENT PASSED\n'.$data.'</script>'; ?>
   
  <?php echo "<script>renderChart();</script>"; ?>


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