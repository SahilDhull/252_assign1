
The base code for this project has been taken from WikiHow:

http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL

A version of the WikiHow page is saved with this project as 'php-secure-login.odt'.

You'll need Apache, mySQL and PHP5.3.x installed and working. 

You'll also need to create a database called 'secure_login'.  When you've done that you need to create a user with just SELECT, UPDATE and DELETE privileges on the 'secure_login' database.  The user's name and password are given in the psl-config.php file.  If you're not intending to contribute, you can choose whatever login details you want, but you'll have to change the psl-config.php file to match your own details.

The code to create and populate the necessary tables is included in the 'secure_login.sql' file.  It populates the members table with a single user with the following details:

Username	: test_user 
Email		: test@example.com 
Password	: 6ZaxN2Vzm9NUJRE


CREATE database secure_login;
USE secure_login;
source address_of_sql_file;


