<?php
ini_set("auto_detect_line_endings", true);
include 'property-features.php';

//------------- get lat and long --------------//
function geocode($address){

    // url encode the address
$address = urlencode($address);

    $json = file_get_contents('http://open.mapquestapi.com/geocoding/v1/address?key=Fmjtd%7Cluu8210r21%2Caw%3Do5-94r2gr&location='.$address);
    $jsonArr = json_decode($json, false);
    $lat1 = $jsonArr->results[0]->locations[0]->latLng->lat;
    $lon1 = $jsonArr->results[0]->locations[0]->latLng->lng;
    $updatedAddress = $jsonArr->results[0]->providedLocation->location;

        // verify if data is complete
    if($lat1 && $lon1){
            // put the data in the array
        $data_arr = array();
        array_push(
            $data_arr,
            $lat1,
            $lon1,
            $updatedAddress
        );
        return $data_arr;
        }else{
            return false;
        }
}
/* ------------- fix property address --------------- */
function ordinal($num) {
    $ones = $num % 10;
    $tens = floor($num / 10) % 10;
    if ($tens === 1) {
        $suff = "th";
    } else {
        switch ($ones) {
            case 1 : $suff = "st"; break;
            case 2 : $suff = "nd"; break;
            case 3 : $suff = "rd"; break;
            default : $suff = "th";
        }
    }
    return $num . $suff;
}


/* ------------------ Open original mls feed csv and create a csv file ------------------*/
$file_handle = fopen("/home/javy1103/public_html/feed/sefl_data.csv", "r");
$file = fopen("/home/javy1103/public_html/wp-content/uploads/wpallimport/files/mlsd.csv", "w");

while (!feof($file_handle)) {

    $line_of_text = fgetcsv($file_handle);
    $photos = intval($line_of_text[88]);
    
      if(!empty($line_of_text[88]) &&
            !empty($line_of_text[27]) && 
            $photos > 0 && 
            ($line_of_text[13] === "S" || 
             $line_of_text[13] === "M" || 
             $line_of_text[13] === "R")
            ){

    /* ------------------ get parking spaces ------------------*/

        $line_of_text[84] = str_replace($patterns, $replacement, $line_of_text[84]);
        if(substr_count($line_of_text[84], "1 parking") || substr_count($line_of_text[84], "1 car garage")){
            $line_of_text[95] = 1;
        }else if (substr_count($line_of_text[84], "2 parking") || substr_count($line_of_text[84], "2 car garage")){
            $line_of_text[95] = 2;
        }else if (substr_count($line_of_text[84], "3 parking") || substr_count($line_of_text[84], "3 car garage")){
            $line_of_text[95] = 3;
        }else if(substr_count($line_of_text[84], "3 parking or more parking") || substr_count($line_of_text[84], "3 or more car")) {
            $line_of_text[95] = "3+";
        }
        
    /* ---------------- Get latitude and longitude -------------------*/

        if(!empty($line_of_text[23])){

            $stMatch = preg_match("/^[0-9]{1,3}[A-Za-z]{2}/", $line_of_text[21]);
            $numMatch = preg_match("/^[0-9]/", $line_of_text[21]);

            if($stMatch < 1 && $numMatch === 1){
            	$stLet = preg_replace("/[^a-zA-Z]/","",$line_of_text[21]);
                $stNum = preg_replace("/[^0-9]/","",$line_of_text[21]);
                $stNum = ordinal($stNum);
                $line_of_text[21] = $stNum." ".$stLet;
            }
            $address = $line_of_text[20].' '.$line_of_text[23].' '.$line_of_text[21].','.$line_of_text[27].',FL,'.$line_of_text[29];
        }else {$address = $line_of_text[20].' '.$line_of_text[21].','.$line_of_text[27].',FL,'.$line_of_text[29];}
        
        $latLong = geocode($address);
        $line_of_text[25] = $latLong[0].', '.$latLong[1];
        $line_of_text[9] = $latLong[2];

    /* -------------------- create photo urls -----------------------*/
        $line_of_text[96] = "";
        $counter = 2;
        //unset($line); 
        $url = $line_of_text[89];
        //$line[0] = $url;

        while ($counter <= $photos && $counter < 8) {
            $photoNumber = '_'.($counter).'.jpg';
            $line_of_text[96+$counter] = substr_replace($url, $photoNumber, sizeof($url) - 5, sizeof($photos)+4);
            $counter++;
        }
        //$line_of_text[98] = implode(",", $line);
        if ($line_of_text[25] != ", "){
            fputcsv($file,$line_of_text, ',', '"');
        }
    }
}
fclose($file_handle);
fclose($file);
?>