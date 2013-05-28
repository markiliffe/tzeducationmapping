<?php require_once 'database_connection.php';

/* This file queries the database 
 * 
 *
 *
 */

$user_input=trim($_GET['user_input']);

$sch=array("'",'"');
$user_input=str_replace($sch,"''", $user_input);

if($user_input!=''){
		//search for the secondary school data
		$sec_record_counter=0;
		$sec_school_data= array();
		$sec_school_query=mysql_query("SELECT a.id as id,  a.sch_no as sno, a.sch_name as sname, a.district as dist
										from tbl_sec_school_results a
										where a.sch_no like '%$user_input%' or a.sch_name like '%$user_input%'  LIMIT 0,10");

		if(mysql_num_rows($sec_school_query) > 0)
			{
				while($row=mysql_fetch_array($sec_school_query))
				{
					$sec_school_data[$sec_record_counter]['school_id']=$row['id'];
					$sec_school_data[$sec_record_counter]['school_no']=$row['sno'];
				
					//formating school name
					$schn=str_replace("'","&quot;", $row['sname']);
						
					$sec_school_data[$sec_record_counter]['school_name']=$schn;
					$sec_school_data[$sec_record_counter]['ditrict_name']=$row['dist'];
					//increment counter
					$sec_record_counter++;
				}
			}

		//initialize record counter and school data array for primary school records
		$pr_record_counter=0;
		$pr_school_data= array();
		$pr_school_query=mysql_query("SELECT a.id as id ,c.reg_no as reg,b.dist_no as dis, b.dist_name as disn, a.sch_no as sch,a.sch_name as sch_name 
										FROM tbl_school_results a
										inner join tbl_districts b on a.tbl_districts_id=b.id
										inner join tbl_region c on b.tbl_region_id=c.id
										WHERE a.sch_no LIKE '%$user_input%' OR concat(c.reg_no,b.dist_no,a.sch_no) LIKE '%$user_input%' LIMIT 0,10");
		
			if(mysql_num_rows($pr_school_query) > 0)
			{
				while($rw=mysql_fetch_array($pr_school_query))
				{
					$pr_school_data[$pr_record_counter]['school_id']=$rw['id'];
					$pr_school_data[$pr_record_counter]['school_no']=$rw['reg'].$rw['dis'].$rw['sch'];
					
					//formating school name
					$schn=str_replace("'","&quot;", $rw['sch_name']);
					$pr_school_data[$pr_record_counter]['school_name']=$schn;
					$pr_school_data[$pr_record_counter]['ditrict_name']=$rw['disn'];
					//increment counter
					$pr_record_counter++;
				}			
			} 

	   $i=0;
		while($i< $sec_record_counter && $i< 5 )
					{	
						?>
                        <div id="dleta"><a href="#" onClick="weka(<?php echo $sec_school_data[$i]['school_id']; ?>,
                        '<?php echo $sec_school_data[$i]['school_name'].' ( '.$sec_school_data[$i]['school_no'].' ) '; ?>
                        ','<?php echo $sec_school_data[$i]['school_id']; ?>')"><?php echo $sec_school_data[$i]['school_name']
						.' ( '.$sec_school_data[$i]['school_no'].' )'; ?></a></div><?php
					$i++;
					
					}
		 $i=0;		
		while($i< $pr_record_counter && $i< 5 )
					{		
						?>
                        <div id="dleta"><a href="#" onClick="weka(<?php echo $pr_school_data[$i]['school_id']; ?>,
                        '<?php echo $pr_school_data[$i]['school_name'].' ( '.$pr_school_data[$i]['school_no'].' ) '; ?>
                        ','<?php echo $pr_school_data[$i]['school_id']; ?>')"><?php echo $pr_school_data[$i]['school_name']
						.' ( '.$pr_school_data[$i]['school_no'].' )'; ?></a></div><?php
					$i++;
					}
}

/*
	$qone=mysql_query("SELECT a.id as id ,c.reg_no as reg,b.dist_no as dis,a.sch_no as sch,a.sch_name as sch_name 
	FROM tbl_school_results a
	inner join tbl_districts b on a.tbl_districts_id=b.id
	inner join tbl_region c on b.tbl_region_id=c.id
	WHERE a.sch_no LIKE '%$user_input%' OR a.sch_name LIKE '%$user_input%' OR b.dist_no LIKE '%$user_input%' OR c.reg_no LIKE '%$user_input%' LIMIT 0,10");
	while($rw=mysql_fetch_array($qone))
	{   $sid=$rw['id'];
	$schn=str_replace("'","&quot;", $rw['sch_name']);
	?>
	<div id="dleta"><a href="#" onClick="weka(<?php echo $rw['id'] ?>,'<?php echo $schn.' ( '.$rw['reg'].$rw['dis'].$rw['sch'].' ) '; ?>')">
	<?php 
		echo $schn.' ( '.$rw['reg'].$rw['dis'].$rw['sch'].' ) '; 
	?></a>

	</div>

	<?php
		}

		} */
?>

