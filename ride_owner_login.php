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
if(isset($_POST["ride_owner_login"]))
{
    // GETTING EMAIL AND PASSWORD FROM RIDE OWNER LOGIN FORM
    $email = $_POST["email"];
    $pw = $_POST["pw"];

    // CHECKING IF USER EXISTS OR NOT
    $sql = "SELECT ride_owner_id FROM ride_owner WHERE email='$email' AND pw='$pw'";
    $result = $conn->query($sql);
    // IF NO USER EXISTS
    if($result->num_rows == 0)
    {
        // REDIRECT TO RIDE OWNER LOGIN PAGE
        $message = "USER DOES NOT EXIST.<a href='ride_owner_signup.php'>SIGN UP</a> INSTEAD.";
        header("Location: ");
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
                $sql = "SELECT ride_owner_id FROM ride_owner WHERE email='$email'";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc())
                {
                    $_SESSION["ride_owner_id"] = $row["ride_owner_id"];
                }
                header("Location: ");
            }
            else
            {
                $message = "USER DOES NOT EXIST.<a href='ride_owner_signup.php'>SIGN UP</a> INSTEAD.";
                // REDIRECT TO RIDE OWNER LOGIN PAGE
                header("Location: ");
            }
        }
    }
}
?>
