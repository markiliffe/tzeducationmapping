<?php
/* This PHP code fetches the school data from the database, using the identification number which
 * is selected from the school results table. This is selected by the 'schoolform' form.
 *
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