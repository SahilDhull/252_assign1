<html>
<title>
Count of Employees
</title>
<body>
<a href = "index.php"> Back to Main Page</a>
<br>
<br>
<?php
//require_once('index.php');
$servername = "localhost";
$username = "root";
$password = "Qwerty@123";
$dbname = "employees";
$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
    die("<br>Connection failed: " . $conn->connect_error);
}
//echo "connected<br>";
if(isset($_POST['submit'])){
    $sql = "select dept_no,count(emp_no) from dept_emp group by dept_no";
    $res = $conn->query($sql) or die(mysql_error());
    echo "Number of Departments = ".$res->num_rows."<br><br>";
    while($row = $res->fetch_assoc()){
        //echo "ok<br>";
        $dept = $row['dept_no'];
        //echo $dept;
        $sql = "select dept_name from departments where dept_no = '$dept'";
        $res1 = $conn->query($sql) or die(mysql_error());
        $row1 = $res1->fetch_assoc();
        echo "Department: ".$row1['dept_name']."<br>Count =
        ".$row['count(emp_no)']."<br><br>";
    }
}

?>



</body>
</html>
