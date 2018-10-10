<html>
<head>
</head>
<body>
<h1>Most Uniquely applied ACT sections</h1>

<?php
// This path should point to Composer's autoloader
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->police->cases;


$cursor3 = $collection->aggregate([ ['$unwind'=>'$Act_Section']  ,  ['$group'=>['_id'=>'$Act_Section','count'=>[  '$sum'=>1  ]]],['$sort'=>['count'=>-1]]]);

echo "<br></br>";
echo "<br></br>";
echo "<style>";
echo "table, th, td { border: 1px solid black;}";
echo "</style>";
echo "<table style='width:100%'>";
echo "<tr>";
echo "<th><b>ACT sections</b></th>";
echo "<th><b>Number of Cases</b></th>";
echo "</tr>";


foreach($cursor3 as $state)
{
	$a = $state['_id'];
	$b = $state['count'];
	echo "<tr>";
	echo "<th>$a</th>";
	echo "<th>$b</th>";
	echo "</tr>";
}
?>
</body>
</html>
