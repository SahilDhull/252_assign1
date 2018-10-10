<html>
<title>
LAB 5
</title>
<body>
<br>
<a href = "index.php"> Back to Main Page</a>
<br><br>
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
if (isset($_POST['submit1'])){
    echo "<br><br> People ordered by tenure:<br><br>";
    $dept = $_POST['dpt'];
    echo "<br>Department : ".$dept."<br><br>Names of employees:<br><br>";
    $sql1 = "select emp_no from dept_emp where dept_no in (select dept_no from departments where dept_name='$dept') order by (to_date-from_date) DESC";
    $res1 = $conn->query($sql1) or die(mysql_error());
    while($row1 = $res1->fetch_assoc()){
        $emp = $row1['emp_no'];
        $sql2 = "select * from employees where emp_no = $emp";
        $res2 = $conn->query($sql2) or die(mysql_error());
        $row2 = $res2->fetch_assoc();
        echo $row2['first_name']." ".$row2['last_name']."<br>";
    }
}
else if(isset($_POST['submit2'])){
    $dept = $_POST['dpt'];
    $sql1="select count(emp_no) from employees where gender='M'
    AND emp_no in (select emp_no from dept_emp
    where dept_no in (select dept_no from departments where dept_name='$dept'))";
    $res1 = $conn->query($sql1) or die(mysql_error());
    $row1 = $res1->fetch_assoc();
    $sql2="select count(emp_no) from employees where gender='F'
    AND emp_no in (select emp_no from dept_emp
    where dept_no in (select dept_no from departments where dept_name='$dept'))";
    $res2 = $conn->query($sql2) or die(mysql_error());
    $row2 = $res2->fetch_assoc();
    echo "<br>Department : ".$dept."<br><br>Gender Ratio (Male to Female): ".round($row1['count(emp_no)']/$row2['count(emp_no)'],2);
}
else{
    header("Location: index.php");
}

?>

</body>
</html>
