<?php require_once 'database_connection.php';

/* This
 * 
 *
 *
 */

$user_input=trim($_GET['user_input']);

$sch=array("'",'"');
$user_input=str_replace($sch,"''", $user_input);

if($user_input!=''){
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

	}
?>

