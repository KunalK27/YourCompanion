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

if(isset($_POST["register_ride"]))
{
    session_start();
    $ride_owner_id = $_SESSION["ride_owner_id"];
    $ride = $_POST["ride"];
    $number_plate = $_POST["number_plate"];
    $sql = "INSERT INTO rides VALUES ('$ride_owner_id', '$ride', '$number_plate')";
    if ($conn->query($sql) !== TRUE)
    {
        echo "Error inserting values: " . $conn->error;
    }
}
?>