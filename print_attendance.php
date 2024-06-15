<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print Attendance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr.present {
            background-color: #d4edda;
            /* Light green */
        }

        tr.absent {
            background-color: #f8d7da;
            /* Light red */
        }

        .button-container {
            text-align: center;
        }

        #printButton {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            background-color: #3A57E8;
        }
    </style>
    <script>
        function printTable() {
            window.print();
            document.getElementById('printButton').style.display = 'none'; // Hide the button after printing
        }
    </script>
</head>

<body>
    <div class="container">
        <h2 style="text-align:center; margin-top:3%;margin-bottom:3%; ">Student's Attendance Report </h2>
        <?php
        date_default_timezone_set('Asia/Amman');
        session_start();
        // Include database connection file
        include 'datastore.php';
        // Connect to the database
        $conn = connect();

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        if (isset($_GET['selected_date']) && isset($_GET['class_id']) && isset($_GET['course_id'])) {
            $selected_date = $_GET['selected_date'];
            $class_id = $_GET['class_id'];
            $course_id = $_GET['course_id'];
        } else {
            die("Required parameters not found.");
        }

        // Fetch attendance data
        $query_attendance = "
            SELECT sr.reg_student_id, s.student_name, 
            CASE 
                WHEN a.student_id IS NOT NULL THEN 'Present' 
                ELSE 'Absent' 
            END as attendance_status
            FROM student_reg sr
            JOIN students s ON sr.reg_student_id = s.student_id
            LEFT JOIN attendance a ON sr.reg_student_id = a.student_id AND DATE(a.attendance_time) = ? AND a.class_id = sr.reg_class
            WHERE sr.reg_cor_id = ? AND sr.reg_class = ?";

        $stmt_attendance = mysqli_prepare($conn, $query_attendance);
        mysqli_stmt_bind_param($stmt_attendance, "sii", $selected_date, $course_id, $class_id);
        mysqli_stmt_execute($stmt_attendance);
        $result_attendance = mysqli_stmt_get_result($stmt_attendance);
        $htmlTable = '<table border="1">';
        $htmlTable .= '<tr><th>Student ID</th><th>Student Name</th><th>Attendance Status</th></tr>';

        if (mysqli_num_rows($result_attendance) > 0) {
            while ($row = mysqli_fetch_assoc($result_attendance)) {
                $attendance_status_class = ($row['attendance_status'] == 'Present') ? 'present' : 'absent';
                $htmlTable .= '<tr class="' . $attendance_status_class . '">';
                $htmlTable .= '<td>' . $row['reg_student_id'] . '</td>';
                $htmlTable .= '<td>' . $row['student_name'] . '</td>';
                $htmlTable .= '<td>' . $row['attendance_status'] . '</td>';
                $htmlTable .= '</tr>';
            }
        } else {
            $htmlTable .= '<tr><td colspan="3">No records found.</td></tr>';
        }

        $htmlTable .= '</table>';
        mysqli_close($conn);
        echo $htmlTable;
        ?>
        <div class="button-container">
            <button id="printButton" onclick="printTable()">Print Attendance</button>
        </div>
    </div>
</body>

</html>