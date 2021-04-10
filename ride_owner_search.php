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
if(isset($_POST["ride_owner_search"]))
{
    session_start();
    $ride_owner_id = $_SESSION["ride_owner_id"];
    $source = $_POST["source"];
    $destination = $_POST["destination"];
    $date_of_ride = $_POST["date_of_ride"];
    $time_of_ride = $_POST["time_of_ride"];
    $number_plate = $_POST["number_plate"];
    $sql = "SELECT number_plate FROM rides WHERE ride_owner_id='$ride_owner_id'";
    $result = $conn->query($sql);
    if($result->num_rows == 0)
    {
        $message = "RIDE NOT REGISTERED";
    }
    else
    {
        $num_rides = $result->num_rows;
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            if($row["number_plate"] == $number_plate)
            {
                $sql = "INSERT INTO ride_owner_search VALUES('$ride_owner_id', '$source', '$destination', '$date_of_ride', '$time_of_ride', '$number_plate')";
                $_SESSION["ride_owner_source"] = $source;
                $_SESSION["ride_owner_destination"] = $destination;
                $_SESSION["ride_owner_date_of_ride"] = $date_of_ride;
                $_SESSION["ride_owner_time_of_ride"] = $time_of_ride;
                $_SESSION["number_plate"] = $number_plate;
                if ($conn->query($sql) !== TRUE)
                {
                    echo "Error inserting values: " . $conn->error;
                }
            }
            else
            {
                if($counter < $num_rides)
                {
                    $counter = $counter + 1;
                }
                else
                {
                    $message = "RIDE NOT REGISTERED";
                }
            }
        }
    }
}
?>
