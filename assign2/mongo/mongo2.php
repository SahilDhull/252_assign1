<html>
<head>
</head>
<body>
<h1> Efficiency of Police Stations</h1>

<?php
// This path should point to Composer's autoloader
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
//echo "connected succesfully";
$collection = $client->police->cases;


$pending = $collection->aggregate([['$match'=>['Status'=>'Pending']], ['$group'=>['_id'=>'$PS','count'=>['$sum'=>1]]],['$sort'=>['_id'=>1]]]);
$total = $collection->aggregate([['$group'=>['_id'=>'$PS','count'=>['$sum'=>1]]],['$sort'=>['_id'=>1]]]);
$efficiency = array();
foreach($total as $state)
{
	$efficiency+=array($state['_id']=>$state['count']);
}
foreach($pending as $state)
{
	$efficiency[$state['_id']]=$efficiency[$state['_id']]/(float)$state['count'];
}
asort($efficiency);
echo "<br></br>";
echo "<br></br>";
echo "<style>";
echo "table, th, td { border: 1px solid black;}";
echo "</style>";
echo "<table style='width:100%'>";
echo "<tr>";
echo "<th><b>Police Station</b></th>";
echo "<th><b>Efficiency</b></th>";
echo "</tr>";
foreach($efficiency as $key => $c)
{
	$a = 1 / (float)$c;
	$a = $a * 100;
	$a = round($a,2);
	echo "<tr>";
	echo "<th>$key</th>";
	echo "<th>$a</th>";
	echo "</tr>";
}
echo "</table>";

?>
</body>
</html>
