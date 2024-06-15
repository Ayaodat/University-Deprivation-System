<?php
date_default_timezone_set('Asia/Amman');

// Include database connection file
include 'datastore.php';
session_start();

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    // If not, destroy the session and redirect to login page
    session_destroy();
    unset($_SESSION['userid']);
    unset($_SESSION['user_name']);
    unset($_SESSION['role']);
    header("location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Attendance Management</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>

<div class="iq-navbar-header" style="width:fit-content">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center">



                </div>

            </div>

        </div>

    </div>

    <div class="iq-header-img">

        <img src="./assets/images/dashboard/top-header.png" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
    </div>

    <!-- Nav Header Component End -->
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card  ">
                                <div class="card-body">

                                    <h2 style="text-align:center; margin-top:3%; ">Student's Attendance List
                                        <svg class="icon-32" style="color:#3A57E8" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.8877 10.8967C19.2827 10.7007 20.3567 9.50473 20.3597 8.05573C20.3597 6.62773 19.3187 5.44373 17.9537 5.21973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M19.7285 14.2505C21.0795 14.4525 22.0225 14.9255 22.0225 15.9005C22.0225 16.5715 21.5785 17.0075 20.8605 17.2815" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8867 14.6638C8.67273 14.6638 5.92773 15.1508 5.92773 17.0958C5.92773 19.0398 8.65573 19.5408 11.8867 19.5408C15.1007 19.5408 17.8447 19.0588 17.8447 17.1128C17.8447 15.1668 15.1177 14.6638 11.8867 14.6638Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8869 11.888C13.9959 11.888 15.7059 10.179 15.7059 8.069C15.7059 5.96 13.9959 4.25 11.8869 4.25C9.7779 4.25 8.0679 5.96 8.0679 8.069C8.0599 10.171 9.7569 11.881 11.8589 11.888H11.8869Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M5.88509 10.8967C4.48909 10.7007 3.41609 9.50473 3.41309 8.05573C3.41309 6.62773 4.45409 5.44373 5.81909 5.21973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M4.044 14.2505C2.693 14.4525 1.75 14.9255 1.75 15.9005C1.75 16.5715 2.194 17.0075 2.912 17.2815" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </h2>


                                    <form id="date_form" method="post" action="" style="text-align:center; margin-top:5%;  ">
                                        <label for="date_selector" style="font-size:20px ; color:black">Select Date:</label>

                                        <input type='date' id="selected_date" name="selected_date" class='form-control' style="width: 270px; text-align:center ; margin-right:auto; margin-left:auto; margin-top:1%;" value="<?php echo date('Y-m-d'); ?>">

                                        <button type="submit" id="toggleAttendanceButton" style=" text-align:center ;width: 270px;; margin-top:1%" class="btn btn-primary">Show Attendance</button>
                                        <br>
                                        <button type="submit" id="show_students_btn" style=" text-align:center ;width: 270px;; margin-top:1%" class="btn btn-primary">Print Attendance Report</button>
                                        <br>
                                        <br>
                                        <br>
                                    </form>

                                    <input type="hidden" id="class_id" value="<?php echo $_GET['class_id']; ?>">
                                    <input type="hidden" id="course_id" value="<?php echo $_GET['course_id']; ?>">
                                    <div id="attendance_data" class="calendar-s" style="text-align: center;color:black; display: none; "></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function fetchAttendance(date) {
            $.ajax({
                url: 'fetch_attendance.php',
                type: 'POST',
                data: {
                    selected_date: date,
                    class_id: $('#class_id').val(),
                    course_id: $('#course_id').val()
                },
                success: function(data) {
                    $('#attendance_data').html(data);
                }
            });
        }

        // Fetch attendance data on page load
        fetchAttendance($('#selected_date').val());

        // Fetch attendance data when the date is changed
        $('#selected_date').change(function() {
            fetchAttendance($(this).val());
        });

        // Fetch attendance data when the form is submitted
        $('#date_form').submit(function(event) {
            event.preventDefault();
            fetchAttendance($('#selected_date').val());
        });

        // Handle delete action
        $(document).on('submit', '.delete_form', function(event) {
            event.preventDefault();
            var form = $(this);
            $.ajax({
                url: 'attendance_actions.php',
                type: 'POST',
                data: form.serialize(),
                success: function(data) {
                    fetchAttendance($('#selected_date').val());
                }
            });
        });



        // Handle fetch into attendance action
        $(document).on('submit', '.fetch_form', function(event) {
            event.preventDefault();
            var form = $(this);
            $.ajax({
                url: 'fetch_student.php',
                type: 'POST',
                data: form.serialize(),
                success: function(data) {
                    fetchAttendance($('#selected_date').val());
                }
            });
        });
        // Toggle visibility of the attendance data
        $('#toggleAttendanceButton').click(function() {
            $('#attendance_data').toggle();
            $('#date_form').toggle(); // Toggle the form visibility when the button is clicked

        });
        $('#show_students_btn').click(function() {
            // Get values from hidden fields
            var selected_date = $('#selected_date').val();
            var class_id = $('#class_id').val();
            var course_id = $('#course_id').val();

            // Construct the URL with parameters
            var url = "print_attendance.php?selected_date=" + selected_date + "&class_id=" + class_id + "&course_id=" + course_id;

            // Redirect to the URL with parameters
            window.location.href = url;
        });
    });
    $(document).on('submit', '#save_absence_form', function(event) {
        event.preventDefault();
        var form = $(this);
        $.ajax({
            url: 'save_absence.php',
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    // alert(response.message.join("\n"));
                    fetchAttendance($('#selected_date').val());
                } else {
                    // alert('Error: ' + response.message.join("\n"));
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // alert('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        });
    });
</script>


</body>

</html>