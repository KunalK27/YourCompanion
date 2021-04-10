<?php
$server = "localhost";
$db = "car_pooling";
$un = "root";
$password = "";

// ESTABLISHING CONNECTION
$conn = new mysqli($server, $un, $password, $db);
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// IF PASSENGER LOGIN IS CLICKED
if(isset($_POST["passenger_login"]))
{
    // GETTING EMAIL AND PASSWORD FROM PASSENGER LOGIN FORM
    $email = $_POST["email"];
    $pw = $_POST["pw"];

    // CHECKING IF USER EXISTS OR NOT
    $sql = "SELECT passenger_id FROM passenger WHERE email='$email' AND pw='$pw'";
    $result = $conn->query($sql);
    // IF NO USER EXISTS
    if($result->num_rows == 0)
    {
        // REDIRECT TO PASSENGER LOGIN PAGE
        header("Location: ");
        $message = "USER DOES NOT EXIST.<a href='passenger_signup.php'>SIGN UP</a> INSTEAD.";
    }
    // IF USER EXISTS
    else
    {
        // CHECK IF EMAIL AND PASSWORD MATCH
        while($row = $result->fetch_assoc())
        {
            // IF EMAIL AND PASSWORDS MATCH
            if($row["email"] == $email && $row["pw"] == $pw)
            {
                // LOGIN SUCCESSFUL
                session_start();
                $sql = "SELECT passenger_id FROM passenger WHERE email='$email'";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc())
                {
                    $_SESSION["passenger_id"] = $row["passenger_id"];
                }
                header("Location: ");
            }
            else
            {
                // REDIRECT TO PASSENGER LOGIN PAGE
                header("Location: ");
                $message = "USER DOES NOT EXIST.<a href='passenger_signup.php'>SIGN UP</a> INSTEAD.";
            }
        }
    }
}
?>
