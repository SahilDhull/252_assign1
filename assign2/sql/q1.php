<html>
<title>
LAB 5
</title>
<body>
<a href = "index.php"> Back to the QUERY Page </a>
<h1>Query Result:</h1>
<br><br>
<?php
$servername = "localhost";
$username = "root";
$password = "Qwerty@123";
$dbname = "employees";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);
//echo "here";
//Check connection
if ($conn->connect_error) {
    die("<br>Connection failed: " . $conn->connect_error);
}
if (isset($_POST['submit'])){
#echo "<br>(Connected successfully :) ) <br>";
$id = $_POST['id'];
$ln = $_POST['ln'];
$dpt = $_POST['dpt'];

#echo
//$sql = "SELECT * FROM employees WHERE last_name = $ln";
//$r = $conn->query($sql);
//echo $r->num_rows;
//echo "something must be printed";
//echo "Record:<br>"."Emp_no Birth-date Name(first and last) Gender Hire date<br>";
echo "<style>";
echo "table, th, td { border: 1px solid black;}";
echo "</style>";
echo "<table style='width:100%'>";
echo "<tr>";
echo "<th>Emp_no</th>";
echo "<th>Birth-date</th>";
echo "<th>First Name</th>";
echo "<th>Last Name</th>";
echo "<th>Gender</th>";
echo "<th>Hiring date</th>";
echo "</tr>";
//format the table properly
if(strlen($id)!=0){
    $sql1 = "SELECT * FROM employees WHERE emp_no  = $id";
    $result1 = $conn->query($sql1);
    if($result1->num_rows > 0)
    {
        while($row = $result1->fetch_assoc()){
            $a1 = $row["emp_no"]; $a2=$row["birth_date"]; $a3 = $row["first_name"]; $a4 = $row["last_name"]; $a5 = $row["gender"]; $a6 = $row["hire_date"];
            echo "<tr>";
            echo "<td>$a1</td>";
            echo "<td>$a2</td>";
            echo "<td>$a3</td>";
            echo "<td>$a4</td>";
            echo "<td>$a5</td>";
            echo "<td>$a6</td>";
            echo "</tr>";
        }
    }
    else echo "Invalid ID<br>";
}
else if(strlen($ln)!=0){
    echo $ln;
    $sql2 = "SELECT * FROM employees WHERE last_name  = '$ln'";
    $result2 = $conn->query($sql2);
    //echo $result2;
    //echo $result2->num_rows;
    //echo "<br>ok<br>";
    if($result2->num_rows > 0)
    {
        while($row = $result2->fetch_assoc()){
            //echo "record must be printed<br>";
            //echo $row["emp_no"]." ".$row["birth_date"]." ".$row["first_name"]."
                //".$row["last_name"]." ".$row["gender"]." ".$row["hire_date"];
            $a1 = $row["emp_no"]; $a2=$row["birth_date"]; $a3 = $row["first_name"]; $a4 = $row["last_name"]; $a5 = $row["gender"]; $a6 = $row["hire_date"];
            echo "<tr>";
            echo "<td>$a1</td>";
            echo "<td>$a2</td>";
            echo "<td>$a3</td>";
            echo "<td>$a4</td>";
            echo "<td>$a5</td>";
            echo "<td>$a6</td>";
            echo "</tr>";
        }
    }
    else echo "Invalid last name<br>";
}
else if(strlen($dpt)!=0){
    #$sql1 = "SELECT * FROM dept_emp WHERE dept_no  = $dpt";
    //$sql3 = "select dept_emp.dept_no, employees.emp_no from dept_emp JOIN
    //employees USING (emp_no) WHERE dept_emp.dept_no = '$dpt'";
    $dept = $_POST['dpt'];
    $sql3 = "select * from dept_emp where dept_no in (select dept_no from departments where dept_name='$dept')";
    $result3 = $conn->query($sql3);
    //echo $result3->num_rows;
    if($result3->num_rows > 0)
    {
        while($row = $result3->fetch_assoc()){
            $emp = $row['emp_no'];
            $sql4 = "select * from employees where emp_no = $emp";
            $res4 = $conn->query($sql4) or die(mysql_error());
            $row1 = $res4->fetch_assoc();
            //echo $row1["emp_no"]." ".$row1["birth_date"]." ".$row1["first_name"]."
            //".$row1["last_name"]." ".$row1["gender"]." ".$row1["hire_date"];
            //echo "<br>";
            $a1 = $row1["emp_no"]; $a2=$row1["birth_date"]; $a3 =
            $row1["first_name"]; $a4 = $row1["last_name"]; $a5 =
            $row1["gender"]; $a6 = $row1["hire_date"];
            echo "<tr>";
            echo "<td>$a1</td>";
            echo "<td>$a2</td>";
            echo "<td>$a3</td>";
            echo "<td>$a4</td>";
            echo "<td>$a5</td>";
            echo "<td>$a6</td>";
            echo "</tr>";
        }
    }
    else echo "<br>Invalid Department<br>";
}
else echo "Empty Query !!!";
}
else{
    header("Location: index.php");
}

?>
<br><br>
</body>
</html>
