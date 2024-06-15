<?php
include 'datastore.php';



if (isset($_GET['class_id']) && isset($_GET['course_id']) && isset($_GET['token'])) {
    $class_id = $_GET['class_id'];
    $cor_id = $_GET['course_id'];
    $token = $_GET['token'];

    $conn = connect();

    // Token Validation
    $stmt = $conn->prepare("SELECT * FROM attendance_tokens WHERE course_id = ? AND class_id = ? AND token = ?");
    $stmt->bind_param("sss", $cor_id, $class_id, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $expiry_time = strtotime($row['expires_at']);
        $current_time = time();

        if ($current_time <= $expiry_time) {
            // Token is valid, display the student ID form
?>

            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <title>Hope UI | Responsive Bootstrap 5 Admin Dashboard Template</title>

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
            <div class="wrapper">
                <div class="container-fluid p-0">
                    <div class="iq-maintenance text-center">


                        <div class="maintenance-bottom text-white pb-0">

                            <div class="bg-primary" style="background: transparent; height: 320px;">

                                <div class="gradient-bottom">
                                    <div class="bottom-text general-zindex" style="margin-bottom:9%">
                                        <h3 style="color:#6C757D"> Record Your Attendance
                                            <svg class="icon-32" color=#3a57e8 width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.67 2H16.34C19.73 2 22 4.38 22 7.92V16.091C22 19.62 19.73 22 16.34 22H7.67C4.28 22 2 19.62 2 16.091V7.92C2 4.38 4.28 2 7.67 2ZM11.43 14.99L16.18 10.24C16.52 9.9 16.52 9.35 16.18 9C15.84 8.66 15.28 8.66 14.94 9L10.81 13.13L9.06 11.38C8.72 11.04 8.16 11.04 7.82 11.38C7.48 11.72 7.48 12.27 7.82 12.62L10.2 14.99C10.37 15.16 10.59 15.24 10.81 15.24C11.04 15.24 11.26 15.16 11.43 14.99Z" fill="currentColor"></path>
                                            </svg>
                                            </h1>
                                            <div class="card" style=" width:50%; margin-left:25% ; margin-top: 5%; margin-bottom:5% ;">
                                                <div class="card-header d-flex justify-content-between" style=" height:70px; text-align:center">
                                                    <div class="header-title">
                                                        <h4 class="card-title">Student ID </h4>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <form method="POST">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="student_id" name="student_id" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </form>
                                                </div>
                                            </div>

                                    </div>
                                    <div class="c xl-circle">
                                        <div class="c lg-circle">
                                            <div class="c md-circle">
                                                <div class="c sm-circle">
                                                    <div class="c xs-circle"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sign-bg">
                        <svg width="280" height="230" viewBox="0 0 431 398" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.05">
                                <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF" />
                                <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF" />
                                <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857" transform="rotate(45 61.9355 138.545)" fill="#3B8AFF" />
                                <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857" transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF" />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>



<?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
                $student_id = $_POST['student_id'];

                // Get IP address
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $date_today = date('Y-m-d');  // Get today's date

                // Check if the IP address has already submitted the form today
                $stmt = $conn->prepare("SELECT * FROM attendance WHERE class_id = ? AND att_ip_address = ? AND DATE(attendance_time) = ?");
                $stmt->bind_param("sss", $class_id, $ip_address, $date_today);
                $stmt->execute();
                $ip_check_result = $stmt->get_result();

                if ($ip_check_result->num_rows > 0) {
                    echo '<div class="alert alert-danger d-flex align-items-center" style="width:50% ; margin-left:25% ; margin-top:42% " role="alert">
                        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.81409 20.4368H19.1971C20.7791 20.4368 21.7721 18.7267 20.9861 17.3527L13.8001 4.78775C13.0091 3.40475 11.0151 3.40375 10.2231 4.78675L3.02509 17.3518C2.23909 18.7258 3.23109 20.4368 4.81409 20.4368Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M12.0024 13.4147V10.3147" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M11.995 16.5H12.005" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <div> This IP address  alreahasdy been used to submit the form for class ID: ' . $class_id . ' today.</div> </div>';
                } else {
                    // Student Validation
                    $stmt = $conn->prepare("SELECT * FROM student_reg 
                                            WHERE reg_cor_id = ? AND reg_class = ? AND reg_student_id = ? 
                                            AND deprived_f = 0 AND withdraw_f = 0");
                    $stmt->bind_param("sss", $cor_id, $class_id, $student_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Check if attendance already recorded for today
                        $stmt = $conn->prepare("SELECT * FROM attendance WHERE student_id = ? AND class_id = ? AND DATE(attendance_time) = ?");
                        $stmt->bind_param("sss", $student_id, $class_id, $date_today);
                        $stmt->execute();
                        $check_result = $stmt->get_result();

                        if ($check_result->num_rows == 0) {
                            // Mark attendance as 'present'
                            $stmt = $conn->prepare("INSERT INTO attendance (student_id, class_id, attendance_status, att_ip_address, attendance_time) 
                                                    VALUES (?, ?, 'present', ?, NOW())");
                            $stmt->bind_param("sss", $student_id, $class_id, $ip_address);
                            if ($stmt->execute() === TRUE) {
                                echo '<div class="alert alert-success d-flex align-items-center" style="width:50% ; margin-left:25% ; margin-top:42% " " role="alert">
                            <svg class="flex-shrink-0 bi me-2 icon-24" width="24" height="24">
                            <use xlink:href="#check-circle-fill" />
                            </svg>
                            <div> Attendance is marked successfully for student ID: ' . $student_id . ' &nbspin class ID: ' . $class_id . '.</div> </div>';
                            } else {
                                echo "Error: " . $conn->error;
                            }
                        } else {
                            echo '<div class="alert alert-danger d-flex align-items-center" style="width:50% ; margin-left:25% ; margin-top:42% " role="alert">
                        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.81409 20.4368H19.1971C20.7791 20.4368 21.7721 18.7267 20.9861 17.3527L13.8001 4.78775C13.0091 3.40475 11.0151 3.40375 10.2231 4.78675L3.02509 17.3518C2.23909 18.7258 3.23109 20.4368 4.81409 20.4368Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M12.0024 13.4147V10.3147" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M11.995 16.5H12.005" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <div> Attendance is already recorded for student ID: ' . $student_id . ' &nbspin class ID: ' . $class_id . '</div> </div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger d-flex align-items-center" style="width:50% ; margin-left:25% ; margin-top:42% " role="alert">
                        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.81409 20.4368H19.1971C20.7791 20.4368 21.7721 18.7267 20.9861 17.3527L13.8001 4.78775C13.0091 3.40475 11.0151 3.40375 10.2231 4.78675L3.02509 17.3518C2.23909 18.7258 3.23109 20.4368 4.81409 20.4368Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M12.0024 13.4147V10.3147" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M11.995 16.5H12.005" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <div>Student not enrolled in this class or is withdrawn/deprived.</div> </div>';
                    }
                }
            }
        } else {
            echo "Token expired for class ID: $class_id";
        }
    } else {
        echo "Invalid token for class ID: $class_id";
    }

    $conn->close();
} else {
    echo "Missing class ID or token";
}
?>





<!-- Library Bundle Script -->
<script src="./assets/js/core/libs.min.js"></script>

<!-- External Library Bundle Script -->
<script src="./assets/js/core/external.min.js"></script>

<!-- Widgetchart Script -->
<script src="./assets/js/charts/widgetcharts.js"></script>

<!-- mapchart Script -->
<script src="./assets/js/charts/vectore-chart.js"></script>
<script src="./assets/js/charts/dashboard.js"></script>

<!-- fslightbox Script -->
<script src="./assets/js/plugins/fslightbox.js"></script>

<!-- Settings Script -->
<script src="./assets/js/plugins/setting.js"></script>

<!-- Slider-tab Script -->
<script src="./assets/js/plugins/slider-tabs.js"></script>

<!-- Form Wizard Script -->
<script src="./assets/js/plugins/form-wizard.js"></script>

<!-- AOS Animation Plugin-->

<!-- App Script -->
<script src="./assets/js/hope-ui.js" defer></script>

<script src="./assets/js/plugins/countdown.js"></script>