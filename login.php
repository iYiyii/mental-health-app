<?php
    include './connect.php';
    session_start(); // will not expire until user closes the browser

    $conn = OpenCon();
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "select userID from Users where email='$email' and password='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['userID'] = $row['userID'];
        header('Location: profile.php');
        die();
    } else {
        echo "<h2> Sorry, you've entered an invalid email/password combo</h2>";
        echo "<br> Please return to the login page <a href='./login.html'>here</a>";
    }
?>