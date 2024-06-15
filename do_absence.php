<?php
session_start();
include 'datastore.php';
$students = $_POST['studentlist'];
$cor = $_POST['cor'];
$class = $_POST['class'];
$date = $_POST['date'];
$action = $_POST['act'];

if ($action == "INSERT") {

    //$x= withdraw_student($student, $cor, $class);
    $x1 = del_abs($cor, $class, $date);

    $arrayFromJS = explode(',', $students);

    if ($x1 == 1) {
        $cnt = 0;

        foreach ($arrayFromJS as $student) {

            $x2 = insert_abs($student, $cor, $class, $date);

            $cnt = $cnt + $x2;
            check_and_notify_absences($student);
        }
        if (count($arrayFromJS) == $cnt) {
            echo 1;
        } else {
            echo 0;
        }
    } else { //x1 else
        echo 0;
    }
}
if ($action == "CHK") {
    $x = get_st_abs($cor, $class, $date);

    echo json_encode($x);
}
