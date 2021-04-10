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

if(isset($_POST["passenger_search"]))
{
    session_start();
    $passenger_id = $_SESSION["passenger_id"];
    $source = $_POST["source"];
    $destination = $_POST["destination"];
    $date_of_ride = $_POST["date_of_ride"];
    $time_of_ride = $_POST["time_of_ride"];
    $sql = "INSERT INTO passenger_search VALUES('$passenger_id', '$source', '$destination', '$date_of_ride', '$time_of_ride')";
    if ($conn->query($sql) !== TRUE)
    {
        echo "Error inserting values: " . $conn->error;
    }
}
?>