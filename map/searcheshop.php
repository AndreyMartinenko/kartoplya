<?php
 
include("bd.php");
 
header('Content-Type: text/html; charset=utf-8');

if($_GET['all_obj_get'] == 'all'){
	$query1= "SELECT * FROM mvideo_shops ORDER BY address";
	$result1 = mysql_query($query1);
	 
	if(mysql_num_rows($result1)>0)
	{
	while ($par1 = mysql_fetch_array($result1)){
	 
	$addressshop[] = array("id"=>$par1['id'],
	 
	"town" => $par1['town'],
	 
	"address" => $par1['address'],
	 
	"lat" => $par1['lat'],
	 
	"lon" => $par1['lon'],
	 
	"rrab" => $par1['grafrab']);
	 
	}
	 
	$json = json_encode($addressshop);
	 
	echo $json;
	 
	}
}

if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
 
$town = $_GET['town'];
 
$query1= "SELECT * FROM mvideo_shops where  town='$town' ORDER BY address";
$result1 = mysql_query($query1);
 
if(mysql_num_rows($result1)>0)
{
while ($par1 = mysql_fetch_array($result1)){
 
$addressshop[] = array("id"=>$par1['id'],
 
"town" => $par1['town'],
 
"address" => $par1['address'],
 
"lat" => $par1['lat'],
 
"lon" => $par1['lon'],
 
"rrab" => $par1['grafrab']);
 
}
 
$json = json_encode($addressshop);
 
echo $json;
 
}
 
}
 
?>