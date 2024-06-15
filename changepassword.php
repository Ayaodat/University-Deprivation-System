<?php
//session_start();

include 'header.php';
// echo $_SESSION['success'];
include('server2.php');

?>



<div class='main_content'>

    <div class='info'>
        <?php
        if (isset($_SESSION['success'])) : ?>
            <div class="error success">
                <h3>
                    <?php
                    //	echo $_SESSION['success']; printing out of the scope z-index
                    unset($_SESSION['success']);
                    ?>
                </h3>
            </div>

        <?php endif ?>

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

        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">

                            </div>
                            <div class="card-body">
                                <form method="post" action="changepassword.php" id="form-wizard1" class="mt-3 text-center" dir="rtl">
                                    <?php include('errors.php'); ?>
                                    <ul id="top-tab-list" class="p-0 row list-inline">
                                        <li class="mb-2 col-lg-3 col-md-6 text-start active" id="account">
                                            <a>
                                                <div class="iq-icon me-3">
                                                    <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <span class="dark-wizard">Account</span>
                                            </a>
                                        </li>
                                        <li id="personal" class="mb-2 col-lg-3 col-md-6 text-start">
                                            <a>
                                                <div class="iq-icon me-3">
                                                    <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                                <span class="dark-wizard">Personal</span>
                                            </a>
                                        </li>
                                        <li id="confirm" class="mb-2 col-lg-3 col-md-6 text-start">
                                            <a>
                                                <div class="iq-icon me-3">
                                                    <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                                <span class="dark-wizard">Finish</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- fieldsets -->
                                    <fieldset style="margin-left: 20%;">
                                        <div class="form-card text-start">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h3 class="mb-4"> تغيير كلمة المرور</h3>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">كلمة المرور الحالية </label>
                                                        <input type="password" class="form-control" name="old_pass" placeholder=" " />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">كلمة المرور الجديدة</label>
                                                    <input type="password" class="form-control" name="con_new_pass" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">تأكيد كلمة المرور الجديدة </label>
                                                    <input type="password" class="form-control" name="new_pass" placeholder="" />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="change_pass" class="btn btn-primary next action-button float-end" value="Next">تغيير</button>
                                    </fieldset>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>