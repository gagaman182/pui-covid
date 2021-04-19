<?php
	 header('Access-Control-Allow-Origin: *');
   
	 include 'conn.php';

 

 $sql = "SELECT
 id,
prename as  'คำนำหน้า',
name as 'ชื่อ',
lastname as 'นามสกุล',
concat('\'',idcard)  as 'หมายเลขบัตรประจำตัวประชาชน',
birth as 'วันเกิด',
age as 'อายุ',
tel as 'เบอร์โทรศัพท์',
address as 'บ้านเลขที่',
road as 'ถนน',
soi as 'ซอย',
moo as 'หมู่',
subdistrict as 'ตำบล',
district as 'อำเภอ',
province as 'จังหวัด',

redaddress as 'พื้นที่เสี่ยง',
redaddress_other as 'พื้นที่เสี่ยงระบุ',
contact as 'สัมผัสใกล้ชิด',
contact_other as 'สัมผัสใกล้ชิดระบุ',
DATE_FORMAT(date_add,'%d-%m-%Y %T') as 'เวลาที่บันทึก'

FROM
 pui
 WHERE state = ''
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
