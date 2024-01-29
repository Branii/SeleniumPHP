<?php

$inputString = "20240127579 #58573249 4 7 7 9 0 2024-01-27 19:18:00";

// Extract data from the input string
$splitString = preg_split("/\s+/", $inputString);
$period = ltrim($splitString[1], "#");
$draws = implode(",", array_slice($splitString, 2, 5));
$date = $splitString[7];
$time = $splitString[8];

// var_dump($splitString);

// exit;
//String Tablename, String drawDate,String drawTime,String drawNumber,String drawCount,String DateCreated, String drawClient, String drawGet
// Construct the new array in the desired format
$resultArray = array(
    "period" => $period,
    "draws" => $draws,
    "date" => $date,
    "time" => $time
);

// Convert the result array to JSON format
$jsonResult = json_encode($resultArray, JSON_PRETTY_PRINT);

// Output the result
echo $jsonResult;
