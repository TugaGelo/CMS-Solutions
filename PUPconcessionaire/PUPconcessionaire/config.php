<?php
//hostname,database name, user, password
$host = "localhost";
$user = "root";
$pwd = "";
$dbname = "pupconcessionaire";

//mysqli_connect("localhost","root","","dba");
$con=mysqli_connect($host,$user,$pwd,$dbname);

if(!$con){
	die(" ERROR:Could not connect because " . mysqli_error());
	}
?>