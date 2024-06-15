<?php
session_start();
include 'datastore.php';

$not = $_POST['notid'];

$x= conf_noti($not);

if($x==1) {
    echo 1;
} else {
    echo 0;
}


?>
