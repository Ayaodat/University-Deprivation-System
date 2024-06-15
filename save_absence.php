<?php
date_default_timezone_set('Asia/Amman');
header('Content-Type: application/json');


// Include database connection file
include 'datastore.php';

// Connect to the database
$conn = connect();
if (!$conn) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . mysqli_connect_error()]));
}

// Check if required data is received
if (isset($_POST['class_id'], $_POST['course_id'], $_POST['selected_date'])) {
    $class_id = $_POST['class_id'];
    $course_id = $_POST['course_id'];
    $selected_date = $_POST['selected_date']; // The date received from the form

    // Get current year and semester using your custom function 
    get_curr_smst($year, $semester);

    // Convert Arabic semester string to numeric value
    $semester = ($semester == "الفصل الأول") ? 1 : (($semester == "الفصل الثاني") ? 2 : 3);

    // Format the date correctly (YYYY-MM-DD)
    $formatted_date = date('Y-m-d', strtotime($selected_date));
    $timestamp = strtotime($formatted_date); // Convert from UNIX timestamp

    // Delete existing absence records for the specified date, class, and course
    $delete_absence = "DELETE FROM students_absence WHERE abs_year = ? AND abs_smst = ? AND abs_corid = ? AND abs_class = ? AND abs_date = FROM_UNIXTIME(?)";
    $stmt_delete = mysqli_prepare($conn, $delete_absence);
    mysqli_stmt_bind_param($stmt_delete, "siisi", $year, $semester, $course_id, $class_id, $timestamp);
    if (mysqli_stmt_execute($stmt_delete)) {
        $response['message'][] = "Existing absence records deleted successfully.";
    } else {
        echo json_encode(["status" => "error", "message" => "Error deleting existing absence records: " . mysqli_stmt_error($stmt_delete)]);
        exit;
    }

    // SQL to fetch students who didn't attend
    $query_not_attended = "
        SELECT sr.reg_student_id
        FROM student_reg sr
        WHERE sr.reg_cor_id = ? 
        AND sr.reg_class = ? 
        AND sr.reg_student_id NOT IN (
            SELECT a.student_id
            FROM attendance a
            WHERE DATE(a.attendance_time) = ? AND a.class_id = sr.reg_class AND a.student_id = sr.reg_student_id
        )";

    $stmt_not_attended = mysqli_prepare($conn, $query_not_attended);
    mysqli_stmt_bind_param($stmt_not_attended, "iis", $course_id, $class_id, $formatted_date);
    mysqli_stmt_execute($stmt_not_attended);
    $result_not_attended = mysqli_stmt_get_result($stmt_not_attended);

    if (mysqli_num_rows($result_not_attended) > 0) {
        // Prepared statement for inserting absence records
        $insert_absence = "INSERT INTO students_absence (abs_year, abs_smst, abs_corid, abs_class, abs_date, abs_studentid, abs_is_exceused) 
                        VALUES (?, ?, ?, ?, FROM_UNIXTIME(?), ?, 0)";

        $stmt_insert = mysqli_prepare($conn, $insert_absence);

        while ($row = mysqli_fetch_assoc($result_not_attended)) {
            $student_id = $row['reg_student_id'];

            mysqli_stmt_bind_param($stmt_insert, "siisii", $year, $semester, $course_id, $class_id, $timestamp, $student_id);

            if (mysqli_stmt_execute($stmt_insert)) {
                check_and_notify_absences($student_id);
                $response['message'][] = "Absence record inserted for student ID: " . $student_id;
            } else {
                echo json_encode(["status" => "error", "message" => "Error inserting absence record: " . mysqli_stmt_error($stmt_insert)]);
                exit;
            }
        }
    } else {
        $response['message'][] = "No students to mark as absent.";
    }

    $response['status'] = "success";
    $response['message'][] = "Absence records have been saved successfully.";
    echo json_encode($response);
} else {
    echo json_encode(["status" => "error", "message" => "Required data not found."]);
}

mysqli_close($conn);
