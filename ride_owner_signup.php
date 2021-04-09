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
$pic_size = 500000;

// IF RIDE OWNER SIGN UP IS CLICKED
if(isset($_POST["ride_owner_signup"]))
{
    // GETTING VALUES FROM PASSENGER SIGN UP FORM
    $fname = $_POST["fname"];
    $date_of_birth = $_POST["date_of_birth"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $pw = $_POST["pw"];
    $phone = $_POST["phone"];
    $locality = $_POST["locality"];
    $city = $_POST["city"];
    $states = $_POST["states"];
    $pincode = $_POST["pincode"];
    $adhaar = $_POST["adhaar"];
    $occupation = $_POST["occupation"];
    $martial_status = $_POST["martital_status"];
    $license = $_POST["license"];

    $passenger_pic = $_FILES["pic"]["name"];
    $passenger_pic_info = explode(".", $passenger_pic);
    $passenger_pic_ext = end($passenger_pic_info);

    $allowed_ext = array("jpg", "JPG", "png", "PNG", "jpeg", "JPEG", "pdf", "PDF");

    // CHECKING WHETHER USER EXISTS OR NOT BASED ON EMAIL, PHONE AND ADHAAR CARD
    $sql = "SELECT email, phone, adhaar FROM ride_owner WHERE email='$email' OR phone='$phone'";
    $result = $conn->query($sql);
    if($result->num_rows == 0)
    {}
}
?>