<?php

//connect to localhost
include "php/connect.php";

//create tables
include "php/create_table.php";

//inserting airport data
if(isset($_POST["airportCode"])){
    $airCode = $_POST["airportCode"];
}
if(isset($_POST["airportName"])){
    $airName = $_POST["airportName"];
}
if(isset($_POST["submitAirport"])){

    //php validation
    $airport_code_error="";
    $airport_name_error="";
    $error_count_airport = 0;
    $count_duplicate = 0;

    if(empty($airCode)){
        $airport_code_error="cannot be empty.";
        $error_count_airport = $error_count_airport + 1;
    }else{
        if(strlen($airCode)<1 && strlen($airCode)>4){
            $airport_code_error= "invalid length.";
            $error_count_airport = $error_count_airport + 1;
        }else{
            //checking duplicacy of the airport code.
            $check_duplicate_aircode = "SELECT `airport_code` FROM `flightinfo`.`airport` WHERE `airport_code` = '$airCode'";
            $result_duplicate = mysqli_query($conn, $check_duplicate_aircode);
            if($result_duplicate){
                $count_duplicate = mysqli_num_rows($result_duplicate);

                if($count_duplicate > 0){
                    $airport_code_error = "airport code already exist. Choose other.";
                    $error_count_airport = $error_count_airport + 1;
                }
            }
        }
    }

    if(empty($airName)){
        $airport_name_error="cannot be empty.";
        $error_count_airport = $error_count_airport + 1;
    }else{
        if(!preg_match("/^[a-zA-Z]*$/",$airName)){
            $airport_name_error="only letters and space allowed.";
            $error_count_airport = $error_count_airport + 1;
        }
    }

    $sqlAir="INSERT INTO `flightinfo`.`airport` (`airport_code`, `airport_name`) VALUES ('$airCode', '$airName');";

    if($error_count_airport==0){
     
        mysqli_query($conn, $sqlAir);

        header('location:php/success.php');

    }
    // checking record created
    // if (mysqli_query($conn, $sqlAir)) {
    //     echo "New record created successfully";
    // } else {
    //     echo "Error: " . $sqlAir . "<br>" . mysqli_error($conn);
    // }
    

}

//flight details entry
if(isset($_POST["fromId"])){
    $fromId = $_POST["fromId"];
}
if(isset($_POST["toId"])){
    $toId = $_POST["toId"];
}
if(isset($_POST["flightNo"])){
    $flightNo = $_POST["flightNo"];
}
if(isset($_POST["departTime"])){
    $departTime = $_POST["departTime"];
}
if(isset($_POST["arrivalTime"])){
    $arrivalTime = $_POST["arrivalTime"];
}

if(isset($_POST["submitFlight"])){

    //php validation for flight
    $from_airport_id_error=" ";
    $to_airport_id_error=" ";
    $flight_no_error=" ";
    $time_error=" ";
    $runway_error=" ";
    $runway_error_2 = " ";
    $flight_error_count = 0;


    if(empty($fromId)){
        $from_airport_id_error="cannot be empty.";
        $flight_error_count= $flight_error_count + 1;
    }else{
        if(strlen($fromId)<1 && strlen($fromId)>4){
            $from_airport_id_error= "invalid length.";
            $flight_error_count= $flight_error_count + 1;
        }else{
            if($fromId==$toId){
                $to_airport_id_error="both airport ids cannot be same.";
                $flight_error_count= $flight_error_count + 1;
            }
        }
    }

    if(empty($toId)){
        $to_airport_id_error="cannot be empty.";
        $flight_error_count= $flight_error_count + 1;
    }else{
        if(strlen($toId)<1 && strlen($toId)>4){
            $to_airport_id_error= "invalid length.";
            $flight_error_count= $flight_error_count + 1;
        }else{
            if($fromId==$toId){
                $to_airport_id_error="both airport ids cannot be same.";
                $flight_error_count= $flight_error_count + 1;
            }
        }
    }


    //checking if same from and to airport ids
    // if($fromId==$toId){
    //     $to_airport_id_error="both airport ids cannot be same.";
    //     $flight_error_count= $flight_error_count + 1;
    // }

    if(empty($flightNo)){
        $flight_no_error="cannot be empty.";
        $flight_error_count= $flight_error_count + 1;
    }else{
        if(strlen($flightNo)<1 && strlen($flightNo)>10){
            $flight_no_error= "invalid length.";
            $flight_error_count= $flight_error_count + 1;
        }else{
            //checking duplicacy of the flight no.
            $check_duplicate_flight = "SELECT `flight_no` FROM `flightinfo`.`flight` WHERE `flight_no` = '$flightNo'";
            $result_duplicate_flight = mysqli_query($conn, $check_duplicate_flight);
            if($result_duplicate_flight){
                $count_duplicate_flight = mysqli_num_rows($result_duplicate_flight);

                if($count_duplicate_flight > 0){
                    $flight_no_error = "flight no. already exist. Choose other.";
                    $flight_error_count= $flight_error_count + 1;
                }
            }
            
        }
    }

    if(empty($departTime) || empty($arrivalTime)){
        $time_error="enter time.";
        $flight_error_count= $flight_error_count + 1;
    }else{
        if($departTime==$arrivalTime){
            $time_error="both cannot be same.";
            $flight_error_count= $flight_error_count + 1;
        }
    }
    /////////////////////////////////////////////////////////////////

    
    //checking time 10 min before and after for depart 
    $toId;      //contains from_airport_id
    $airport_to_id_time = "SELECT arrival_time FROM `flightinfo`.`flight` WHERE to_airport_id = $toId; " ;
    $to_result = mysqli_query($conn, $airport_to_id_time);
        if($to_result){
            if (mysqli_num_rows($to_result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($to_result)) {
                    // echo "time: " . $row["depart_time"]."<br>";
                    $time_to = $row["arrival_time"];
                    // echo $time_to;
                    // echo "<br>";
                    //converting the existing time to timestamp
                    $time_to_stamp = strtotime($time_to);
                    // echo $time_to_stamp ." " ;
                    // echo date('H:i:s', $time_to_stamp);
                    //creating timestamp for 10min after
                    // echo "<br>";
                    $after_time =$time_to_stamp + 600;
                    // echo $after_time ." " ;
                    // echo date('H:i:s', $after_time);
                    //creating timestamp for 10min before
                    // echo "<br>";
                    $before_time = $time_to_stamp - 600;
                    // echo $before_time ." " ;
                    // echo date('H:i:s', $before_time);
                    //taking input depart time and converting to timestamp
                    // echo "<br>";
                    $time_arrival_stamp = strtotime($arrivalTime);
                    // echo $time_arrival_stamp ." " ;
                    // echo date('H:i:s', $time_arrival_stamp);
                    
                    if($before_time < $time_arrival_stamp && $after_time > $time_arrival_stamp){
                        $runway_error_2 = "Runway occupied .";
                        $flight_error_count= $flight_error_count + 1;
                    }
     
                }
            } else {
                echo "0 results";
            }
    }
    /////////////////////////////////////////////////////////////////
    //checking time 10 min before and after for arrival
    $fromId;      //contains from_airport_id
    $airport_from_id_time = "SELECT depart_time FROM `flightinfo`.`flight` WHERE from_airport_id = $fromId; " ;
    $result = mysqli_query($conn, $airport_from_id_time);
        if($result){
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    // echo "time: " . $row["depart_time"]."<br>";
                    $time_from = $row["depart_time"];
                    // echo $time_from;
                    // echo "<br>";
                    //converting the existing time to timestamp
                    $time_from_stamp = strtotime($time_from);
                    // echo $time_from_stamp ." " ;
                    // echo date('H:i:s', $time_from_stamp);
                    //creating timestamp for 10min after
                    // echo "<br>";
                    $after_time =$time_from_stamp + 600;
                    // echo $after_time ." " ;
                    // echo date('H:i:s', $after_time);
                    //creating timestamp for 10min before
                    // echo "<br>";
                    $before_time = $time_from_stamp - 600;
                    // echo $before_time ." " ;
                    // echo date('H:i:s', $before_time);
                    //taking input depart time and converting to timestamp
                    // echo "<br>";
                    $time_depart_stamp = strtotime($departTime);
                    // echo $time_depart_stamp ." " ;
                    // echo date('H:i:s', $time_depart_stamp);
                    
                    if($before_time < $time_depart_stamp && $after_time > $time_depart_stamp){
                        $runway_error="Runway occupied .";
                        $flight_error_count= $flight_error_count + 1;
                    }
     
                }
            } else {
                echo "0 results";
            }
    }




    ////////////////////////////////////////////////////////////////////
    $sqlFlight="INSERT INTO `flightinfo`.`flight` (`from_airport_id`, `to_airport_id`, `flight_no`, `depart_time`, `arrival_time`) VALUES ('$fromId', '$toId', '$flightNo', '$departTime', '$arrivalTime');";

    if($flight_error_count==0){

        mysqli_query($conn, $sqlFlight);

        header('location:php/success.php');
        
    }

    // checking recoed created
    // if (mysqli_query($conn, $sqlFlight)) {
    //     echo "New record created successfully";
    // } else {
    //     echo "Error: " . $sqlFlight . "<br>" . mysqli_error($conn);
    // }

// 

    
    
    
    
    
    
    // $q=mysqli_query($conn, $airport_from_id_time);
    // echo "s1";
    //     echo "s2";
    // if($q === TRUE){
    //     echo "1";
    // }
    // else{
    //     echo "2";
    // }
    


    

}



//closing connection
mysqli_close($conn);

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Flight Details</title>

    <!-- jquery cdn -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- bootstrap cdn -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <!-- jquery validation -->
    <script src="script.js"></script>

    <style>
        body{
            margin:0;
            padding:0;
            height:100vh;
            width:100vw;
            overflow-x:hidden;
            background-image: linear-gradient(to top, rgba(0, 30, 75, 0), rgba(0, 0, 0, 0.7)), url("https://images.pexels.com/photos/230976/pexels-photo-230976.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940");
            /* background:url("https://images.pexels.com/photos/230976/pexels-photo-230976.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940") no-repeat; */
            background-size:cover;
            background-position:center;
        }
        .navbar a{
            font-size:2em;
            font-weight:400;
            /* letter-spacing:5px; */
        }
        h2{
            color:#ccc;
        }
        label{
            color: #fff;
        }
        .error{
            color:#dc3545;
            font-size:12.8px;
        }
    </style>
    </head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-dark">
        <a class="navbar-brand" href="#">FlightInfo.</a>
    </nav>

    <!-- form for airport -->
    <div class="row">
        <div class="container">
        <h2 class="mt-5">Enter Airport Details</h2>

            <form action="index.php" method="post">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                    <label for="airCode">Airport Code</label>
                    <input type="text" class="form-control" id="airCode" placeholder="Airport Code" name="airportCode" >
                    <div class="invalid-feedback d-none" id="errorAirCode">
                        Please provide a valid and unique code.
                    </div>
                    <?php 
                    if (!empty($airport_code_error)){
                        echo "<div class='error'>".$airport_code_error."</div>";
                    }
                    ?>

                    </div>
                    <div class="col-md-6 mb-3">
                    <label for="airName">Airport Name</label>
                    <input type="text" class="form-control" id="airName" placeholder="Airport Name" name="airportName">
                    <div class="d-none invalid-feedback" id="errorAirName">
                        Please provide a valid name.
                    </div>
                    <?php 
                    if(!empty($airport_name_error)){
                        echo "<div class='error'>".$airport_name_error."</div>";
                    }
                    ?>
                    </div>
                </div>
            <button class="btn btn-primary float-right" id="airSubmit" name="submitAirport" type="submit">Add Record</button>
            </form>
        </div>
    </div>

    <!-- form for flight details -->
    <div class="row">
        <div class="container">
            <h2 class="mt-5">Enter Flight Details</h2>
            <form action="index.php" method="post">
                <div class="form-row">
                    <div class="col-md-5 mb-3">
                    <label for="fromAirId">From Airport Id</label>
                    <input type="number" class="form-control" id="fromAirId" name="fromId" placeholder="from Airport" >
                    <div class="d-none invalid-feedback" id="error_fl_from_air">
                        Please provide a valid Id.
                    </div>
                    <?php 
                    if(!empty($from_airport_id_error)){
                        echo "<div class='error'>".$from_airport_id_error."</div>";
                    }
                    ?>
                    </div>
                    <div class="col-md-5 mb-3">
                    <label for="toAirId">To Airport Id</label>
                    <input type="number" class="form-control" id="toAirId" name="toId" placeholder="to Airport" >
                    <div class="d-none invalid-feedback" id="error_fl_to_air">
                        Please provide a valid Id.
                    </div>
                    <?php 
                    if(!empty($to_airport_id_error)){
                        echo "<div class='error'>".$to_airport_id_error."</div>";
                    }
                    ?>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-4 mb-3">
                    <label for="flightNumber">Flight Number</label>
                    <input type="text" class="form-control" id="flightNumber" name="flightNo" placeholder="Flight" >
                    <div class="d-none invalid-feedback" id="error_fl_number">
                        Please provide a valid and unique flight number.
                    </div>
                    <?php 
                    if(!empty($flight_no_error)){
                        echo "<div class='error'>".$flight_no_error."</div>";
                    }
                    ?>
                    </div>

                    <div class="col-md-3 mb-3">
                    <label for="departTime">Departure Time</label>
                    <input type="time" class="form-control" id="departTime" name="departTime" value="00:00:00" >
                    <!-- <div class="d-none invalid-feedback" id="error_fl_dept">
                        Please provide a valid name.
                    </div> -->
                    <?php 
                    if(!empty($runway_error)){
                        echo "<div class='error'>".$runway_error."</div>";
                    }
                    ?>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                    <label for="arrTime">Arrival Time</label>
                    <input type="time" class="form-control" id="arrTime" name="arrivalTime" value="00:00:00" >
                    <div class="d-none invalid-feedback" id="error_fl_arrival">
                        Arrival and departure time cannot be same.
                    </div>
                    <?php 
                    if(!empty($time_error)){
                        echo "<div class='error'>".$time_error."</div>";
                    }
                    if(!empty($runway_error)){
                        echo "<div class='error'>".$runway_error_2."</div>";
                    }
                    ?>
                    </div>
                </div>
                <button class="btn btn-primary float-right" id="flightSubmit" name="submitFlight" type="submit">Add Record</button>
            </form>
        </div>
    </div>
</body>
</html>