<?php
 header('Content-Type:application/json');
 header('Access-Control-Allow-Origin: *');
 header('Access-Control-Allow-Methods: PUT');
 header('Access-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization');
 $data = json_decode(file_get_contents('php://input'),true);

 $state_update = $data['state_update'];
 $idcard = $data['idcard'];


 


include 'conn.php';










if (!empty($idcard)) {
 

    
       $strvisit  = "  UPDATE pui
       SET state = '".$state_update."',date_update = CURRENT_TIMESTAMP
       WHERE idcard = '".$idcard."'
       ";
        
        
        
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