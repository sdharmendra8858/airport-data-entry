<?php

//create table airport to keep airport data
$airportTableSql = "CREATE TABLE  `flightinfo`.`airport` (
    `id` INT( 4 ) NOT NULL AUTO_INCREMENT ,
    `airport_code` VARCHAR( 6 ) NOT NULL ,
    `airport_name` VARCHAR( 255 ) NOT NULL ,
    PRIMARY KEY (  `airport_code` ) ,
    UNIQUE (
    `id`
    )
    );
    ";

mysqli_query($conn, $airportTableSql);

//checking table is created or not 
// if (mysqli_query($conn, $airportTableSql)) {
//     echo "Table airport created successfully";
// } else {
//     echo "Error creating table: " . mysqli_error($conn);
// }


//create table flight to keep flight records
$flightTableSql = "CREATE TABLE  `flightinfo`.`flight` (
    `id` INT( 4 ) NOT NULL AUTO_INCREMENT ,
    `from_airport_id` VARCHAR( 4 ) NOT NULL ,
    `to_airport_id` VARCHAR( 4 ) NOT NULL ,
    `flight_no` VARCHAR( 10 ) NOT NULL ,
    `depart_time` VARCHAR( 10 ) NOT NULL ,
    `arrival_time` VARCHAR( 10 ) NOT NULL ,
    PRIMARY KEY (  `flight_no` ) ,
    UNIQUE (
    `id`
    )
    );
    ";
mysqli_query($conn, $flightTableSql);

// checking table is created or not
// if (mysqli_query($conn, $flightTableSql)) {
//     echo "Table flight created successfully";
// } else {
//     echo "Error creating table: " . mysqli_error($conn);
// }



?>