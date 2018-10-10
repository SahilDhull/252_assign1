<html>
<title>
LAB 5
</title>
<body>
<br>
<a href = "index.php"> Back to Main Page</a>
<br>
<h1>Gender Pay Ratio:</h1>
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

if(isset($_POST['submit'])){
    $dept_name = $_POST['dept'];
    $title=$_POST['title'];
    // echo $title."<br>".$dept_name."<br>";
    $sql1="select sum(salary) from salaries
    where emp_no in (select emp_no from employees
    where emp_no in (select emp_no from titles where title='$title'
    and emp_no in (select emp_no from dept_emp
    where dept_no in (select dept_no from departments where dept_name='$dept_name'))) and gender='M')
    and to_date in (select max(to_date) from salaries
    where emp_no in (select emp_no from titles))";
    $sql2="select sum(salary) from salaries
    where emp_no in(select emp_no from employees
    where emp_no in(select emp_no from titles where title='$title'
    and emp_no in (select emp_no from dept_emp
    where dept_no in (select dept_no from departments where dept_name='$dept_name'))) and gender='F')
    and to_date in (select max(to_date) from salaries
    where emp_no in (select emp_no from titles))";
    $res1 = $conn->query($sql1) or die(mysql_error());
    $row1 = $res1->fetch_assoc();
    echo $row1->num_rows;
    $res2 = $conn->query($sql2) or die(mysql_error());
    $row2 = $res2->fetch_assoc();
    // echo "ok";
    echo "Gender Pay Ratio for $dept_name Department and Title: $title = ".round($row1['sum(salary)']/$row2['sum(salary)'],2);


}
else{
    header("Location: index.php");
}

?>

</body>
</html>
