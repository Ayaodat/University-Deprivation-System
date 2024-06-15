<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Favicon -->
    <link rel="shortcut icon" href="./assets/images/favicon.ico" />

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="./assets/css/core/libs.min.css" />


    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="./assets/css/hope-ui.min.css?v=2.0.0" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="./assets/css/custom.min.css?v=2.0.0" />

    <!-- Dark Css -->
    <link rel="stylesheet" href="./assets/css/dark.min.css" />

    <!-- Customizer Css -->
    <link rel="stylesheet" href="./assets/css/customizer.min.css" />

    <!-- RTL Css -->
    <link rel="stylesheet" href="./assets/css/rtl.min.css" />
</head>
<?php
date_default_timezone_set('Asia/Amman');

// Include database connection file
include 'datastore.php';

// Connect to the database
$conn = connect();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['selected_date'])) {
    $selected_date = $_POST['selected_date'];
} else {
    $selected_date = date('Y-m-d');
}

if (isset($_POST['class_id']) && !empty($_POST['class_id']) && isset($_POST['course_id']) && !empty($_POST['course_id'])) {
    $class_id = $_POST['class_id'];
    $course_id = $_POST['course_id'];
} else {
    die("Class ID or Course ID not found.");
}

$query_attendance = "
    SELECT attendance.*, students.student_name 
    FROM attendance 
    JOIN students ON attendance.student_id = students.student_id 
    WHERE DATE(attendance.attendance_time) = ? AND attendance.class_id = ?";

$stmt_attendance = mysqli_prepare($conn, $query_attendance);
mysqli_stmt_bind_param($stmt_attendance, "si", $selected_date, $class_id);
mysqli_stmt_execute($stmt_attendance);
$result_attendance = mysqli_stmt_get_result($stmt_attendance);

$htmlTable_attended = ' <br><br> <br><label style="font-size: 21px;">Attendance for ' . $selected_date . '</label>';
$htmlTable_attended .= '<table border="1" style="  margin-left: auto; margin-right: auto;  ;margin-top:1%" id="mytable"  id="datatable" class="table table-striped">';
$htmlTable_attended .= '<tr><th>Student ID</th><th>Student Name</th><th>Attendance Status</th><th>Action</th></tr>';

if (mysqli_num_rows($result_attendance) > 0) {
    while ($row = mysqli_fetch_assoc($result_attendance)) {
        $htmlTable_attended .= '<tr>';
        $htmlTable_attended .= '<td>' . $row['student_id'] . '</td>';
        $htmlTable_attended .= '<td>' . $row['student_name'] . '</td>';
        $htmlTable_attended .= '<td>' . $row['attendance_status'] . '</td>';
        $htmlTable_attended .= '<td><form class="delete_form" method="post" action="attendance_actions.php">';
        $htmlTable_attended .= '<input type="hidden" name="record_id" value="' . $row['id'] . '">';
        $htmlTable_attended .= '<button type="submit" class="btn btn-primary">Delete</button>';
        $htmlTable_attended .= '</form></td>';
        $htmlTable_attended .= '</tr>';
    }
} else {
    $htmlTable_attended .= '<tr><td colspan="4">No attendance records found for ' . $selected_date . '.</td></tr>';
}

$htmlTable_attended .= '</table>';

$query_not_attended = "
SELECT 
    sr.reg_student_id,
    s.student_name
FROM student_reg sr
JOIN students s ON sr.reg_student_id = s.student_id
WHERE sr.reg_cor_id = ? 
  AND sr.reg_class = ? 
  AND sr.reg_student_id NOT IN (
      SELECT a.student_id
      FROM attendance a
      WHERE DATE(a.attendance_time) = ? AND a.class_id = sr.reg_class AND a.student_id = sr.reg_student_id
  )";

$stmt_not_attended = mysqli_prepare($conn, $query_not_attended);
mysqli_stmt_bind_param($stmt_not_attended, "iis", $course_id, $class_id, $selected_date);
mysqli_stmt_execute($stmt_not_attended);
$result_not_attended = mysqli_stmt_get_result($stmt_not_attended);

$htmlTable_not_attended = ' <br> <br> <br><label style="font-size: 21px;">Abcense for '  . $selected_date . '</label>';
$htmlTable_not_attended .= '<table border="1"  style="  margin-left: auto; margin-right: auto;margin-top: 1%" id="mytable"  id="datatable" class="table table-striped">';
$htmlTable_not_attended .= '<tr><th>Student ID</th><th>Student Name</th><th>Action</th></tr>';

if (mysqli_num_rows($result_not_attended) > 0) {
    while ($row = mysqli_fetch_assoc($result_not_attended)) {
        $htmlTable_not_attended .= '<tr>';
        $htmlTable_not_attended .= '<td>' . $row['reg_student_id'] . '</td>';
        $htmlTable_not_attended .= '<td>' . $row['student_name'] . '</td>';
        $htmlTable_not_attended .= '<td><form class="fetch_form" method="post" action="">';
        $htmlTable_not_attended .= '<input type="hidden" name="student_id" value="' . $row['reg_student_id'] . '">';
        $htmlTable_not_attended .= '<input type="hidden" name="class_id" value="' . $class_id . '">';
        $htmlTable_not_attended .= '<input type="hidden" name="selected_date"  class="form-control" value="' . $selected_date . '">';
        $htmlTable_not_attended .= '<button type="submit" class="btn btn-primary">Fetch Into Attendance</button>';
        $htmlTable_not_attended .= '</form></td>';
        $htmlTable_not_attended .= '</tr>';
    }
} else {
    $htmlTable_not_attended .= '<tr><td colspan="3">All students attended for ' . $selected_date . '.</td></tr>';
}

$htmlTable_not_attended .= '</table> <br> ';
$htmlTable_not_attended .= '<form id="save_absence_form" method="post" action="save_absence.php">';
$htmlTable_not_attended .= '<input type="hidden" name="class_id" value="' . $class_id . '">';
$htmlTable_not_attended .= '<input type="hidden" name="course_id" value="' . $course_id . '">';
$htmlTable_not_attended .= '<input type="hidden" name="selected_date" value="' . $selected_date . '">';
$htmlTable_not_attended .= '<button type="submit" class="btn btn-primary">Save</button></form>';

echo $htmlTable_attended;
echo $htmlTable_not_attended;
mysqli_close($conn);
