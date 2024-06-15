<?php
session_start();
include 'datastore.php';
if (!isset($_SESSION['userid'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: start.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['userid']);
    unset($_SESSION['user_name']);
    unset($_SESSION['role']);
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>

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

<body>

    <div class="header">
        <h2>Home Page</h2>
    </div>
    <div class="content">
        <!-- notification message -->
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success">
                <h3>
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>

        <!-- logged in user information -->
        <?php if (isset($_SESSION['userid'])) :
            $arr = get_user_info($_SESSION['userid']);
            $info = extract($arr[0], EXTR_PREFIX_SAME, "wddx");
            //userid, userpass, username, role, userdept, uercol, personname
            //echo $personname;
            //print_r($arr);
            if ($role == 3 or $role == 4) {
                $dispname = $personname . " / " . $username;
            } else {
                $dispname = $personname;
            }

            $_SESSION['dispname'] = $dispname;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            //echo "<p>Welcome <strong> $dispname </strong></p>";
            header("location: home.php");
        ?>


            <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
        <?php endif ?>
    </div>





</body>

</html>