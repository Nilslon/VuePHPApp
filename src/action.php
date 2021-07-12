<?php
$mysqli = new mysqli("db","root","example","dev");

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$received_data = json_decode(file_get_contents("php://input"));
$data = array();
if($received_data->action == 'fetchallstations')
{
    $sql = "
    SELECT * FROM stations 
    ORDER BY id DESC
    ";
     
    $result = $mysqli->query($sql)->fetch_all(MYSQLI_ASSOC);
    foreach($result as $row) {
        $data[] = $row;
    }
   
    echo json_encode($data);
}
if($received_data->action == 'fetchallbikes')
{
    $sql = "
    SELECT * FROM bikes 
    ORDER BY id DESC
    ";
     
    $result = $mysqli->query($sql)->fetch_all(MYSQLI_ASSOC);
    foreach($result as $row) {
        $data[] = $row;
    }
   
    echo json_encode($data);
}



$mysqli -> close();
?>
