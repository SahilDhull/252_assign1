<?php
/**
 * Copyright (C) 2013 peredur.net
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
include_once 'includes/forgot.inc.php';
include_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Forgot Password Form</title>
        <script type="text/JavaScript" src="js/zxcvbn.js"></script>
        <script type="text/JavaScript" src="js/sha512.js"></script>
        <script type="text/JavaScript" src="js/forms.js"></script>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <h1>Please answer the following </h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
       
        <form method="post" name="forgot form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">
            Username: <input type='text' name='username' id='username' /><br>
            Email: <input type="text" name="email" id="email" /><br>
            New Password: <input type="password"
                             name="password"
                             id="password"/><br>
            Confirm password: <input type="password"
                                     name="confirmpwd"
                                     id="confirmpwd" /><br>
            Security Question: 
            <select name="question">
                <option value="flower">What is your favourite flower?</option>
                <option value="color">What is your favourite color?</option>
                <option value="friend">Who is your best friend?</option>
                <option value="school">What was the name of your first School?</option>
            </select><br>
            Answer: <input type="text" name="ans" id="ans" /><br>
            <input type="button"
                   value="Go!"
                   onclick="return forformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd   );" />
        </form>
        <p>Return to the <a href="index.php">login page</a>.</p>
    </body>
</html>
