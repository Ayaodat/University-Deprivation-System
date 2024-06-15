<?php
session_start();
include 'datastore.php';
$student = $_POST['student'];
$cor = $_POST['corid'];
$class = $_POST['classid'];
$abscnt = $_POST['abscnt'];
$action = $_POST['action'];


var_dump($role);

if ($action == "INSERT") {
    $x = deprived_student($student, $cor, $class, $abscnt);

    if ($x == 1) {
        echo 1;
    } else {
        echo 0;
    }
}
if ($action == "DELETE") {
    $x = del_deprived_student($student, $cor, $class);

    if ($x == 1) {
        echo 1;
    } else {
        echo 0;
    }
}
if ($action == "UPDATE") {
    $act = $_POST['val'];
    // val=2 confirm  val=3 reject

    $x = update_deprived_student($student, $cor, $class, $_SESSION["role"], $act);
    if ($x == 1 and $_SESSION["role"] == 4 and $act == 2) {
        $xx = transfer_deprived($student, $cor, $class);
        if ($xx == 1) {
            echo 1;
        } else {
            echo 0;
        }
    } else if ($x == 1) {
        echo 1;
    } else {
        echo 0;
    }
}
