<?php
header('Content-Type: application/json');

// Include database connection file
include 'datastore.php';


// Connect to the database
$conn = connect();

if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . mysqli_connect_error()]);
    exit();
}

if (isset($_POST['student_id']) && isset($_POST['class_id']) && isset($_POST['selected_date'])) {
    $student_id = $_POST['student_id'];
    $class_id = $_POST['class_id'];
    $selected_date = $_POST['selected_date'];

    $query_check_attendance = "SELECT * FROM attendance WHERE student_id = ? AND class_id = ? AND DATE(attendance_time) = ?";
    $stmt_check_attendance = mysqli_prepare($conn, $query_check_attendance);
    mysqli_stmt_bind_param($stmt_check_attendance, "iis", $student_id, $class_id, $selected_date);
    mysqli_stmt_execute($stmt_check_attendance);
    $result_check_attendance = mysqli_stmt_get_result($stmt_check_attendance);

    if (mysqli_num_rows($result_check_attendance) > 0) {
        echo json_encode(["status" => "error", "message" => "Attendance record already exists for this student on " . $selected_date]);
    } else {
        $att_ip_address = "Added by instructor";
        $query_insert_attendance = "INSERT INTO attendance (student_id, class_id, attendance_status, attendance_time, att_ip_address) VALUES (?, ?, '.present', ?, ?)";
        $stmt_insert_attendance = mysqli_prepare($conn, $query_insert_attendance);
        mysqli_stmt_bind_param($stmt_insert_attendance, "iiss", $student_id, $class_id, $selected_date, $att_ip_address);
        mysqli_stmt_execute($stmt_insert_attendance);

        if (mysqli_stmt_affected_rows($stmt_insert_attendance) > 0) {
            echo json_encode(["status" => "success", "message" => "Student successfully fetched into attendance for " . $selected_date]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to fetch student into attendance."]);
        }

        mysqli_stmt_close($stmt_insert_attendance);
    }

    mysqli_free_result($result_check_attendance);
    mysqli_stmt_close($stmt_check_attendance);
} else {
    echo json_encode(["status" => "error", "message" => "Student ID, Class ID, or Selected Date is missing."]);
}

mysqli_close($conn);
