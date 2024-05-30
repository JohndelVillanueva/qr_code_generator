<?php
   $data = array(
    'first_name' => '$john',
    'last_name' => '$doe'
);

$json_data = json_encode($data);

echo $json_data;
?>