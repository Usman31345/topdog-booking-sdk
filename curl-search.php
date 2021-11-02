<?php


  

function httpGet($url)
{
	$link = mysqli_connect("localhost", "bwt_cms_site", "bwt_cms_site", "bwt_wp_cms_dev"); 
  
if ($link === false) { 
    die("ERROR: Could not connect. "
                .mysqli_connect_error()); 
} 
    $ch = curl_init();  
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//  curl_setopt($ch,CURLOPT_HEADER, false); 
 
    $output=curl_exec($ch);
 
    curl_close($ch);

// get url id and database values

$destinationId = explode('-', $_GET['destinationId']);

$sql = mysqli_query($link, "SELECT  hsd.ttss_id AS ttss_id,
hsd.giata_id AS giata_id,
hsd.hotel_image_gallery AS hotel_image_gallery,
hsd.bwt_star_rating AS bwt_star_rating,
hsd.hotel_name AS hotel_name,
hsd.hotel_destination AS hotel_destination,
hsd.hotel_location AS hotel_location,
hsd.hotel_was_price AS hotel_was_price,
hsd.hotel_types AS hotel_types,
hsd.hotel_facilities AS hotel_facilities,
hsd.hotel_room_facilities AS hotel_room_facilities,
dc.country_name AS country_name,
dr.resort_name AS resort_name,
hsd.hotel_was_price AS was_price
FROM hotel_supplier_data AS hsd
 LEFT JOIN destination_countries AS dc
 ON dc.ttss_destination_country_id = hsd.ttss_destination_country_id
 LEFT JOIN destination_resorts AS dr
 ON dr.ttss_destination_resort_id = hsd.ttss_destination_resort_id
WHERE hsd.ttss_destination_country_id = $destinationId[0] AND
 hsd.ttss_destination_region_id = $destinationId[1] AND
  hsd.ttss_destination_area_id = $destinationId[2] AND 
  hsd.ttss_destination_resort_id = $destinationId[3]");

$master_array = array();
$rows = array();
while($r = mysqli_fetch_assoc($sql)) {
  $row = array();

    // $image_unserialize     = unserialize($r['hotel_image_gallery']);
    $row['ttssId']     	   = $r['ttss_id'];
	$row['giataId']        = $r['giata_id'];
    // $row['hotelImage']     = $image_unserialize;
    $row['hotelName']      = $r['hotel_name'];
    $row['rating']         = $r['bwt_star_rating'];
    // $row['country']        = $r['hotel_destination'];
    // $row['hotelLocation']  = $r['hotel_location'];
    // $row['wasPrice']       = $r['hotel_was_price'];
    // $room_unserialize      = unserialize($r['hotel_facilities']);
    // $row['room_fac']       = $room_unserialize;
        $row['country']       = $r['country_name'];
    	$row['resort']       = $r['resort_name'];
        $row['wasPrice']       = $r['was_price'];


    $explodeName = explode(' ', $r['hotel_name']);
    $row['hotelLink'] = 'http://devbwt.digient.co/'.$explodeName[0].'-'.$explodeName[1].'/'.$r['giata_id'];
    // print_r($explodeName[0].'-'.$explodeName[1].'/'.$r['giata_id']);die;
	// $row['hotelLink']  = $explodeName[0].'-'$explodeName[1].'/'.$r['giata_id'];

$rows[] = $row;

}
// print_r($rows);die;
$master_array['Results'] = $rows;
$result = [];
$result['Results'] = [];
$hotelId = [];
$images = ["http://devbwt.digient.co/search-results/assets/11.jpg" ,
"http://devbwt.digient.co/search-results/assets/22.jpg",
"http://devbwt.digient.co/search-results/assets/33.jpg",
"http://devbwt.digient.co/search-results/assets/Yvg6DVAbEE.jpg",
"http://devbwt.digient.co/search-results/assets/55.jpg",
"http://devbwt.digient.co/search-results/assets/F48UfIaivF.jpg"];

foreach ($master_array['Results'] as $key => $value) {
	foreach (json_decode($output)->Results as $ke1 => $value1) {
		if($value['ttssId'] == $value1->hotel->hotelId){
			// print_r($value1);die();
			if(in_array($value['ttssId'],$hotelId)){ continue;}
			$value1->images     	= $images[$key];
			$value1->giataID    	= $value["giataId"];
			$value1->HotelName    	= $value["hotelName"];
			$value1->link    		= $value["hotelLink"];
			$value1->country    	= $value["country"];
			$value1->resort    		= $value["resort"];
            $value1->wasPrice       = $value["wasPrice"];


$linkArray = base64_encode($value1->HotelName.'_/'.$value1->images.'_/'.$value1->totalPrice.'_/'.$value1->wasPrice.'_/'.$value1->hotel->rating);
            $value1->linkDetailPage       = $linkArray;

			array_push($result['Results'], $value1);
			array_push($hotelId,  $value1->hotel->hotelId);
		}
	}
}

echo json_encode($result);

}
 $data=json_decode(file_get_contents('php://input'),1);

$duration = $data['duration'];
$durationMin = $data['durationMin'];
$durationMax = $data['durationMax'];
$dateMin = $data['dateMin'];
$dateMax = $data['dateMax'];
$adults = $data['adults'];
$destinationId = $data['destinationId'];
$departureId = $data['departureId'];
$rating = $data['rating'];

if($data != ''){
echo httpGet("http://broadway.website.api.ttss.net/dpSearch.php?duration=$duration&durationMin=$durationMin&durationMax=$durationMax&dateMin=$dateMin&dateMax=$dateMax&adults=$adults&destinationId=$destinationId&maxResults=100&departureId=$departureId&rating=$rating&outputFormat=json");
}else{
	echo httpGet("http://broadway.website.api.ttss.net/dpSearch.php?duration=7&durationMin=7&durationMax=7&dateMin=2020-08-01&dateMax=2020-08-01&adults=2&destinationId=30&maxResults=100&departureId=-1&rating=345&outputFormat=json");
}