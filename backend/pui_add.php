<?php
 header('Content-Type:application/json');
 header('Access-Control-Allow-Origin: *');
 header('Access-Control-Allow-Methods: PUT');
 header('Access-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization');
 $data = json_decode(file_get_contents('php://input'),true);

 $prename = $data['prename'];
 $name = $data['name'];
 $lastname = $data['lastname'];
 $idcard = $data['idcard'];
 $birth = $data['birth'];
 $age = $data['age'];
 $tel = $data['tel'];
 $address = $data['address'];
 $road = $data['road'];
 $soi = $data['soi'];
 $moo = $data['moo'];
 $subdistrict = $data['subdistrict'];
 $district = $data['district'];
 $province = $data['province'];
 $redaddress = $data['redaddress'];
 $redaddress_other = $data['redaddress_other'];
 $contact = $data['contact'];
 $contact_other = $data['contact_other'];


 


include 'conn.php';





 // หา record ล่าสุด
$sql = "SELECT max(id) as total from pui";
 
if ($result = mysqli_query( $conn, $sql )){
  
   while ($row = mysqli_fetch_assoc($result)) {

     $id=$row['total']+1;
 }
}




if (!empty($idcard)) {
 

    
       $strvisit  = "  INSERT INTO pui(id,prename,name,lastname,idcard,birth,
       age,tel,address,road,soi,moo,
       subdistrict,district,province,redaddress,
       redaddress_other,contact,contact_other,date_add) 
        VALUES('".$id."','".$prename."','".$name."','".$lastname."','".$idcard."','".$birth."',
        '".$age."','".$tel."','".$address."','".$road."','".$soi."','".$moo."',
        '".$subdistrict."','".$district."','".$province."','".$redaddress."'
        ,'".$redaddress_other."','".$contact."','".$contact_other."',CURRENT_TIMESTAMP)";
        
        
        
        if ($conn->query($strvisit) === TRUE) {
          
            
            $return_message = array();
            $row_array['message'] = "เพิ่มข้อมูลสำเร็จ";
            array_push($return_message,$row_array);
        
        
        } else {
           
            $return_message = array();
            $row_array['message'] = "เพิ่มข้อมูลไม่สำเร็จ";
            array_push($return_message,$row_array);
            
        }


      }
      
mysqli_close($conn);
	
echo json_encode($return_message);

?>