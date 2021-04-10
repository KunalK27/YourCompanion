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
if(isset($_POST["passenger_signup"]))
{
    //CREATING A RANDOM PASSENGER ID
    function passenger_id_generator()
    {
        $passenger_id = "PASS-";
        $letters = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $random_keys = array_rand($letters, 10);
        for($i = 0; $i < 10; $i = $i + 1)
        {
            $passenger_id = $passenger_id . $letters[$random_keys[$i]];
        }
        return $passenger_id;
    }
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

    $passenger_pic = $_FILES["pic"]["name"];
    $passenger_pic_info = explode(".", $passenger_pic);
    $passenger_pic_ext = end($passenger_pic_info);

    $allowed_ext = array("jpg", "JPG", "png", "PNG", "jpeg", "JPEG", "pdf", "PDF");
    $message = "";

    // CHECKING WHETHER USER EXISTS OR NOT BASED ON EMAIL, PHONE AND ADHAAR CARD
    $sql = "SELECT email, phone, adhaar FROM passenger WHERE email='$email' OR phone='$phone' OR adhaar='$adhaar'";
    $result = $conn->query($sql);
    // NO USER EXISTS
    if($result->num_rows == 0)
    {
        // INSERTING VALUES INPUT BY USER
        if($_FILES["pic"]["size"] < $passenger_pic_size && in_array($passenger_pic_ext, $allowed_ext))
        {
            $passenger_id = passenger_id_generator();
            // CREATE A FOLDER 'PASSENGER' TO SAVE PASSENGER PICS
            move_uploaded_file($_FILES["pic"]["tmp_name"], "passenger/" . $_FILES["pic"]["name"]);
            $sql = "INSERT INTO passenger(passenger_id, fname, date_of_birth, gender, email, pw, phone, locality, city, states, pincode, adhaar, occupation, martial_status, pic) VALUES ('$passenger_id', '$fname', '$date_of_birth', '$gender', '$email', '$pw', '$phone', '$locality', '$city', '$states', '$pincode', '$adhaar', '$occupation', '$martial_status', '$pic')";
            if ($conn->query($sql) !== TRUE)
            {
                echo "Error inserting values: " . $conn->error;
            }
            else
            {
                $message = "USER CREATED SUCCESSFULLY";
            }
        }
    }
    // SOME USERS EXIST
    else
    {
        // GETTING NUMBER OF EXISTING USERS AND INITALIZING COUNTER TO 0
        $num_users = $result->num_rows;
        $counter = 0;
        // PARSING THROUGH EMAIL, PHONE AND ADHAAR OF EACH USER
        while($row = $result->fetch_assoc())
        {
            // IF EMAIL, PHONE OR ADHAAR MATCHED TO EXISTING USER
            if($row["email"] == $email || $row["phone"] == $phone || $row["adhaar"] == $adhaar)
            {
                $message = "USER ALREADY EXISTS";
            }
            // IF EMAIL, PHONE OR ADHAAR DO NOT MATCH
            else
            {
                // AND PARSING OF EXISTING USERS IS ALSO FINISHED
                if($counter == $num_users)
                {
                    // INSERTING VALUES INPUT BY USER
                    if($_FILES["pic"]["size"] < $pic_size && in_array($passenger_pic_ext, $allowed_ext))
                    {
                        $passenger_id = passenger_id_generator();
                        // CREATE A FOLDER 'PIC' TO SAVE PASSENGER PICS
                        move_uploaded_file($_FILES["pic"]["tmp_name"], "pic/" . $_FILES["pic"]["name"]);
                        $sql = "INSERT INTO passenger(passenger_id, fname, date_of_birth, gender, email, pw, phone, locality, city, states, pincode, adhaar, occupation, martial_status, pic) VALUES ('$passenger_id', '$fname', '$date_of_birth', '$gender', '$email', '$pw', '$phone', '$locality', '$city', '$states', '$pincode', '$adhaar', '$occupation', '$martial_status', '$pic')";
                        if ($conn->query($sql) !== TRUE)
                        {
                            echo "Error inserting values: " . $conn->error;
                        }
                        else
                        {
                            $message = "USER CREATED SUCCESSFULLY";
                        }
                    }
                }
                // AND PARSING OF EXISTING USERS ALSO NOT FINISHED
                else
                {
                    $counter = $counter + 1;
                }
            }
        }
    }
}
?>
