<?php
	 header('Access-Control-Allow-Origin: *');
   
	 include 'conn.php';

    $datesearch = $_GET["datesearch"];
  
    // $idcard = '1909700055388';
   
      $sql = "SELECT
      id,
     prename ,
     name ,
     lastname ,
   
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
     where DATE_FORMAT(date_add,'%Y-%m-%d') like '".$datesearch."'
    
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
