<?php

/*
 * Copyright (C) 2013 peter
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

include_once 'db_connect.php';
include_once 'psl-config.php';

$error_msg = "";

if (isset($_POST['username'], $_POST['email'], $_POST['p'],$_POST['question'],$_POST['ans'])) {
    // Sanitize and validate the data passed in
    
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $ques = filter_input(INPUT_POST,'question');
    $ans = filter_input(INPUT_POST, 'ans');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }

    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
		//echo $password;
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }

    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //

    $prep_stmt = "SELECT id,ques,ans FROM members WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);

    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">No user with this email address</p>';
        }
    } else {
        $error_msg .= '<p class="error">Database error</p>';
    }

		$prep_stmt1 = "SELECT id,ques,ans FROM members WHERE username = ? LIMIT 1";
    $stmt1 = $mysqli->prepare($prep_stmt1);

    if ($stmt1) {
        $stmt1->bind_param('s', $username);
        $stmt1->execute();
        $res = $stmt1->get_result();
        //$stmt1->store_result();

        if ($res->num_rows == 0) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">No user with this username</p>';
						
        }
        else if($res->num_rows==1){
            //$stmt1->bind_result($id, $ques1, $ans1);
            $row = $res->fetch_assoc();
            
            //$error_msg .= '<p class="error">TTTTTTTTTTTTTT</p>';
            if($ques == $row["ques"] && $ans == $row["ans"])
            {
                echo "Success!";
            }
            else
            {
                $error_msg .= '<p class="error">Wrong security question or answer</p>';
            }
        }
    } else {
        $error_msg .= '<p class="error">Database error</p>';
    }

    // TODO:
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.

    if (empty($error_msg)) {
        // Create a random salt
        $error_msg .= '<p class="error">It was</p>';
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

        // Create salted password
        $password = hash('sha512', $password . $random_salt);

        // Insert the new user into the database
        if ($insert_stmt = $mysqli->prepare("UPDATE members SET password = ?, salt = ? WHERE email = ?")) {
            $insert_stmt->bind_param('sss', $password, $random_salt, $email);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
                exit();
            }
        }
        header('Location: ./forgot_success.php');
        exit();
    }
}
