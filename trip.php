<?php
$server = "localhost";
$db = "car_pooling";
$un = "root";
$password = "";

// ESTABLISHING CONNECTION
$conn = new mysqli($server, $un, $password);
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

function trip_id_generator()
{
    $trip_id = "TRIP-";
    $letters = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    $random_keys = array_rand($letters, 10);
    for($i = 0; $i < 10; $i = $i + 1)
    {
        $trip_id = $trip_id . $letters[$random_keys[$i]];
    }
    return $trip_id;
}

if(isset($_POST["trip"]))
{
    session_start();
    $ride_owner_id = $_SESSION["ride_owner_id"];
    $passenger_id = $_SESSION["passenger_id"];
    $trip_id = trip_id_generator();
    $source = $_SESSION["ride_owner_source"];
    $destination = $_SESSION["ride_owner_destination"];
    $date_of_ride = $_SESSION["ride_owner_date_of_ride"];
    $time_of_ride = $_SESSION["ride_owner_time_of_ride"];
    $number_plate = $_SESSION["number_plate"];
    $sql = "INSERT INTO trip VALUES('$ride_owner_id', '$passenger_id', '$number_plate', '$date_of_ride', '$time_of_ride', '$source', '$destination', '$trip_id')";
    if ($conn->query($sql) !== TRUE)
    {
        echo "Error inserting values: " . $conn->error;
    }
}
?>