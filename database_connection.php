
 <!-- This file allows connection to the database. It called the mysql_connect() function.
  To use this on your own machine or deployment you will have to supply your database's credentials.-->
 
<?php
$con=mysql_connect('localhost','root','root');
$db=mysql_select_db('brn',$con);
?>