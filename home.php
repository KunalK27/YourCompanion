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

// CREATING DATABASE
$sql = "CREATE DATABASE " . $db;
if ($conn->query($sql) !== TRUE)
{
    echo "Error creating database: " . $conn->error;
}

// ESTABLISHING CONNECTION TO NEWLY CREATED DATABASE
$conn = new mysqli($server, $un, $password, $db);
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

// CREATING TABLES
// PASSENGER
$sql = "CREATE TABLE passenger(
passenger_id VARCHAR(15) PRIMARY KEY,
fname VARCHAR(50) NOT NULL,
date_of_birth DATE NOT NULL,
gender INT(1) NOT NULL,
email VARCHAR(30) NOT NULL,
pw VARCHAR(20) NOT NULL,
phone INT(10) NOT NULL,
locality VARCHAR(30) NOT NULL,
city VARCHAR(20) NOT NULL,
states VARCHAR(15) NOT NULL,
pincode INT(6) NOT NULL,
adhaar INT(12) NOT NULL,
occupation VARCHAR(20) NOT NULL,
marital_status INT(1),
pic VARCHAR(30) NOT NULL)";
if ($conn->query($sql) !== TRUE)
{
    echo "Error creating table: " . $conn->error;
}
// RIDE OWNER
$sql = "CREATE TABLE ride_owner(
ride_owner_id VARCHAR(15) PRIMARY KEY,
fname VARCHAR(50) NOT NULL,
date_of_birth DATE NOT NULL,
gender INT(1) NOT NULL,
email VARCHAR(30) NOT NULL,
pw VARCHAR(20) NOT NULL,
phone INT(10) NOT NULL,
locality VARCHAR(30) NOT NULL,
city VARCHAR(20) NOT NULL,
states VARCHAR(15) NOT NULL,
pincode INT(6) NOT NULL,
adhaar INT(12) NOT NULL,
occupation VARCHAR(20) NOT NULL,
marital_status INT(1),
pic VARCHAR(30) NOT NULL,
license_number VARCHAR(15) NOT NULL)";
if ($conn->query($sql) !== TRUE)
{
    echo "Error creating table: " . $conn->error;
}
// RIDES
$sql = "CREATE TABLE rides(
ride_owner_id VARCHAR(15) REFERENCES ride_owner(ride_owner_id) ON DELETE CASCADE,
ride VARCHAR(20) NOT NULL,
number_plate VARCHAR(10) PRIMARY KEY)";
if ($conn->query($sql) !== TRUE)
{
    echo "Error creating table: " . $conn->error;
}
// PASSENGER SEARCH
$sql = "CREATE TABLE passenger_search(
passenger_id VARCHAR(15) PRIMARY KEY REFERENCES passenger(passenger_id) ON DELETE CASCADE,
source VARCHAR(100) NOT NULL,
destination VARCHAR(100) NOT NULL,
date_of_ride DATE NOT NULL,
time_of_ride TIME NOT NULL)";
if ($conn->query($sql) !== TRUE)
{
    echo "Error creating table: " . $conn->error;
}
// RIDE OWNER SEARCH
$sql = "CREATE TABLE ride_owner_search(
ride_owner_id VARCHAR(15) PRIMARY KEY REFERENCES ride_owner(ride_owner_id) ON DELETE CASCADE,
source VARCHAR(100) NOT NULL,
destination VARCHAR(100) NOT NULL,
date_of_ride DATE NOT NULL,
time_of_ride TIME NOT NULL,
number_plate VARCHAR(10) NOT NULL)";
if ($conn->query($sql) !== TRUE)
{
    echo "Error creating table: " . $conn->error;
}
// TRIP
$sql = "CREATE TABLE trip(
ride_owner_id VARCHAR(15) REFERENCES ride_owner(ride_owner_id) ON DELETE CASCADE,
passenger_id VARCHAR(15) REFERENCES passenger(passenger_id) ON DELETE CASCADE,
number_plate VARCHAR(10) REFERENCES rides(number_plate) ON DELETE CASCADE,
date_of_ride DATE REFERENCES ride_owner_search(date_of_ride) ON DELETE CASCADE,
time_of_ride TIME REFERENCES ride_owner_search(time_of_ride) ON DELETE CASCADE,
source VARCHAR(100) REFERENCES passenger_search(source) ON DELETE CASCADE,
destination VARCHAR(100) REFERENCES passenger_search(destination) ON DELETE CASCADE,
trip_id VARCHAR(5) PRIMARY KEY)";
if ($conn->query($sql) !== TRUE)
{
    echo "Error creating table: " . $conn->error;
}
?>
