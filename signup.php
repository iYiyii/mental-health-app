<!DOCTYPE html> 
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/main.css">
</head>

<body>
<h1>Thank you for signing up! Please navigate to your homepage <a href="./login.html">here</a>
</h1>

<?php
    include 'connect.php';
    session_start();
    $conn = OpenCon();

    addUser();
    
    function addUser() {
        global $conn;
        $type = $_POST["type"];
        $name = $_POST["name"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $age = $_POST["age"] ? : NULL;
        $location = $_POST["location"] ? : NULL;
        $phone = $_POST["phone"] ? : NULL;

        if (!$type) {
            returnError();
            return;
        }
        
        $sql = "insert into Users (password, name, age, location, email, phone)"; 
        $sql .= "values ('$password', '$name', $age, '$location', '$email', '$phone');";
    
        $result = $conn->query($sql);
        if (!$result) {
            returnError();
            return;
        }
    
        $sql = "select userID from Users where email='$email';";
        $result= $conn->query($sql);
        if (!$result) {
            returnError();
            return;
        }
    
        $id = $result->fetch_assoc()["userID"];
        $_SESSION["userID"] = $id;
    
        if ($type == "Counsellor") {
            $yearsExp = $_POST["yearsExp"];
            $cert = $_POST["cert"];
            $sql = "insert into Counsellor (userID, yearsExperience, certification) values";
            $sql .= "($id, $yearsExp, '$cert');";
            $result = $conn->query($sql);

            if (!$result) {
                returnError();
                return;
            }
            
        } else {
            $sql = "insert into HelpSeeker (userID) values ($id);";
            $result = $conn->query($sql);

            if (!$result) {
                returnError();
                return;
            }
        }
    }

    function returnError() {
        echo "<div class='alert alert-primary'> Sorry, could not create your account. Try again</div>";
    }
?>

</body>
</html>