<html>
<title>
LAB 5
</title>
<head>
<h1>Query the DB</h1>
</head>
<body>
<form action="q1.php" method="POST">
   <p> ID <input type="text" name="id"> </p>
   <p> Last Name <input type="text" name="ln"> </p>
   <p> Department <input type="text" name="dpt"></p>
   <input type="submit" name="submit" value="Submit" />
</form>
<br>
For employee count in each department, Click here.
<br>
<form action="q2.php" method="POST">
<br>
   <input type="submit" name="submit" value="Count" />
</form>
<br>
<form action="q3.php" method="POST">
   <p> Department <input type="text" name="dpt"></p>
   <br>For employees by tenure <br>
   <input type="submit" name="submit1" value="Here" />
   <br><br>
   <br>For Gender Ratio <br>
   <input type="submit" name="submit2" value="Here" />
</form>
<br>
Gender Pay Ratio:
<form action="q5.php" method="POST">
    <p> Department <input type="text" name="dept"></p>
    <p> Title <input type="text" name="title"></p>
    <input type="submit" name="submit" value="Here" />
</form>
</body>
</html>
