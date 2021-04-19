<?php
	 header('Access-Control-Allow-Origin: *');
   
	 include 'conn.php';

 

 $sql = "SELECT
 id,
prename ,
name ,
lastname ,
-- concat('\'',idcard) as idcard,
idcard,
birth ,
age ,
tel ,
address ,
road ,
soi ,
moo ,
subdistrict ,
district ,
province ,

redaddress ,
redaddress_other ,
contact ,
contact_other ,
DATE_FORMAT(date_add,'%d-%m-%Y %T') as date_add 

FROM
 pui
 WHERE state = ''
 order by date_add desc
 ";


$return_arr = array();

if ($result = mysqli_query( $conn, $sql )){
    while ($row = mysqli_fetch_assoc($result)) {
	
     array_push($return_arr,$row);
   }
 }

mysqli_close($conn);

echo json_encode($return_arr);








?>
