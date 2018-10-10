<html>
<head>
</head>
<body>
<h1> Most cases reported in respective districts</h1>
<?php
// This path should point to Composer's autoloader
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
//echo "connected succesfully";
$collection = $client->police->cases;

$cursor1 = $collection->aggregate( [ ['$group'=>['_id' => '$DISTRICT','count'=>['$sum'=>1]] ],['$sort'=>['count'=>-1]] ] );
//$cursor1 = $collection->find(['DISTRICT'=>'AGRA']);

echo "<br></br>";
echo "<br></br>";
echo "<style>";
echo "table, th, td { border: 1px solid black;}";
echo "</style>";
echo "<table style='width:100%'>";
echo "<tr>";
echo "<th><b>District</b></th>";
echo "<th><b>Cases</b></th>";
echo "</tr>";

foreach($cursor1 as $state)
{
	$a = $state['_id'];
	$b = $state['count'];
	echo "<tr>";
	echo "<th>$a</th>";
	echo "<th>$b</th>";
	echo "</tr>";
}
echo "</table>";
?>
</body>
</html>
