<?php

function ValidateLogin($email, $password) {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM user_admin WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if ($password === $user['password']) { 
            return $user; 
        } else {
            return null; 
        }
    } else {
        return null; 
    }

    mysqli_close($conn);
}


function Register($email, $name, $last, $password, $username) {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = mysqli_real_escape_string($conn, $email);
    $name = mysqli_real_escape_string($conn, $name);
    $last = mysqli_real_escape_string($conn, $last);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Store the plain text password in the database
    $insert = "INSERT INTO user_admin (email, last, name, password, username, type) 
               VALUES ('$email', '$last', '$name', '$password', '$username', 'user')";
    
    if (mysqli_query($conn, $insert)) {
        $report = 'Registration Complete!';
          header('location: ../gamepage.php');
    exit();
    
    } else {
        $report = 'Error: ' . $insert . '<br>' . mysqli_error($conn);
    }
  
    // Close connection
    mysqli_close($conn);
    return $report;
}
