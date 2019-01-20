<?php
$servername="localhost";
$username="root";
$password="";


//create connection
$conn = mysqli_connect($servername, $username, $password);

//check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$dbname = mysqli_select_db($conn,"flightInfo");
if(empty($dbname)){

    $dbcreate = "CREATE DATABASE flightInfo";
    $check=mysqli_query($conn, $dbcreate);
    if(!$check){
        echo "cannot create";
    }

}

//checking db is created or not
// if (mysqli_query($conn, $dbcreate)) {
//     echo "database created successfully";
// } else {
//     echo "Error creating database: " . mysqli_error($conn);
// }

?>