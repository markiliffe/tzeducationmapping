
 <!-- This file allows connection to the database. It called the mysql_connect() function.
  To use this on your own machine or deployment you will have to supply your database's credentials.-->
 
 <!--Heroku Details: mysql://be2a6a862030db:51cc303e@us-cdbr-east-03.cleardb.com/heroku_1c814cc48ffb566?reconnect=true -->
<?php
$con=mysql_connect('us-cdbr-east-03.cleardb.com','be2a6a862030db','51cc303e');
$db=mysql_select_db('heroku_1c814cc48ffb566',$con);
?>