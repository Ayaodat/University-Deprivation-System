<?php
include 'header.php';
require_once 'delete_token.php';

if ($_SESSION['role'] != 2) {
   session_destroy();
   unset($_SESSION['userid']);
   unset($_SESSION['user_name']);
   unset($_SESSION['role']);
   header("location: login.php");
}
$var = get_curr_smst($year1, $semestar);
$username = (int)filter_var($_SESSION["userid"], FILTER_SANITIZE_NUMBER_INT);
$var2 = get_inst_sch($username);

//print_r($var2);
$shours = 0; ?>

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>login</title>

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
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between">

            </div>
            <div class="card-body">

               <div class="table-responsive">
                  <?php
                  $htmlTable = '<table dir="rtl" id="datatable" class="table table-striped">';
                  $htmlTable .= '<thead><tr><th  colspan=12 style="text-align: center;font-weight:bold ;vertical-align: middle;">
                 <span style="margin-right:20%;" >  ' . $semestar . ' ' . $year1 . ' </span></th></tr>';
                  $htmlTable .= '
                     <tr>
                     <th>id</th>
                     <th>رقم المادة </th>
                     <th> اسم المادة </th>
                     <th> الشعبة </th>
                     <th>  س. م</th>
                     <th> الايام </th>
                     <th> من </th>
                     <th> الى </th>
                     <th> المدرس</th>
                     <th> القاعة</th>
                     <th style=" margine">  <svg class="icon-32" style="margin-right:30%" width="32" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">                                
                     <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M9.18824 3.74722C9.18824 3.33438 8.84724 3 8.42724 3H8.42624L6.79724 3.00098C4.60624 3.00294 2.82324 4.75331 2.82324 6.90279V8.76201C2.82324 9.17386 3.16424 9.50923 3.58424 9.50923C4.00424 9.50923 4.34624 9.17386 4.34624 8.76201V6.90279C4.34624 5.57604 5.44624 4.4964 6.79824 4.49444L8.42724 4.49345C8.84824 4.49345 9.18824 4.15907 9.18824 3.74722ZM17.1931 3.00029H15.6001C15.1801 3.00029 14.8391 3.33468 14.8391 3.74751C14.8391 4.15936 15.1801 4.49277 15.6001 4.49277H17.1931C18.5501 4.49277 19.6541 5.57535 19.6541 6.90603V8.7623C19.6541 9.17415 19.9951 9.50952 20.4151 9.50952C20.8361 9.50952 21.1761 9.17415 21.1761 8.7623V6.90603C21.1761 4.75165 19.3901 3.00029 17.1931 3.00029ZM9.23804 6.74266H14.762C15.367 6.74266 15.948 6.98094 16.371 7.40554C16.797 7.83407 17.033 8.40968 17.032 9.00883V10.2542C17.027 10.4003 16.908 10.5189 16.759 10.5229H7.23904C7.09104 10.518 6.97204 10.3993 6.96904 10.2542V9.00883C6.95804 7.76837 7.97404 6.75541 9.23804 6.74266Z" fill="currentColor"></path>                               
                      <path d="M22.239 12.0413H1.762C1.342 12.0413 1 12.3756 1 12.7885C1 13.2003 1.342 13.5337 1.762 13.5337H2.823V17.0972C2.823 19.2467 4.607 20.9971 6.798 20.999L8.427 21C8.848 21 9.188 20.6656 9.189 20.2528C9.189 19.841 8.848 19.5066 8.428 19.5066L6.8 19.5056C5.447 19.5036 4.346 18.424 4.346 17.0972V13.5337H6.969V14.5251C6.959 15.7656 7.974 16.7795 9.238 16.7913H14.762C16.027 16.7795 17.042 15.7656 17.032 14.5251V13.5337H19.655V17.0933C19.655 18.425 18.551 19.5066 17.194 19.5066H15.601C15.18 19.5066 14.839 19.841 14.839 20.2528C14.839 20.6656 15.18 21 15.601 21H17.194C19.39 21 21.177 19.2487 21.177 17.0933V13.5337H22.239C22.659 13.5337 23 13.2003 23 12.7885C23 12.3756 22.659 12.0413 22.239 12.0413Z" fill="currentColor"></path>                                </svg>   </th>
                      <th>  <svg class="icon-32" style="margin-right:30%" width="32" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">                                    <path d="M17.8877 10.8967C19.2827 10.7007 20.3567 9.50473 20.3597 8.05573C20.3597 6.62773 19.3187 5.44373 17.9537 5.21973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M19.7285 14.2505C21.0795 14.4525 22.0225 14.9255 22.0225 15.9005C22.0225 16.5715 21.5785 17.0075 20.8605 17.2815" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8867 14.6638C8.67273 14.6638 5.92773 15.1508 5.92773 17.0958C5.92773 19.0398 8.65573 19.5408 11.8867 19.5408C15.1007 19.5408 17.8447 19.0588 17.8447 17.1128C17.8447 15.1668 15.1177 14.6638 11.8867 14.6638Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8869 11.888C13.9959 11.888 15.7059 10.179 15.7059 8.069C15.7059 5.96 13.9959 4.25 11.8869 4.25C9.7779 4.25 8.0679 5.96 8.0679 8.069C8.0599 10.171 9.7569 11.881 11.8589 11.888H11.8869Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M5.88509 10.8967C4.48909 10.7007 3.41609 9.50473 3.41309 8.05573C3.41309 6.62773 4.45409 5.44373 5.81909 5.21973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M4.044 14.2505C2.693 14.4525 1.75 14.9255 1.75 15.9005C1.75 16.5715 2.194 17.0075 2.912 17.2815" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                </svg>                            
                      </th>
                      </tr>
                              </thead>';
                  foreach ($var2 as $row) {
                     $htmlTable .= '<tr>';
                     $shours += $row['cor_hours'];
                     //var_dump($row);
                     foreach ($row as $cell) {
                        $htmlTable .= '<td>' . $cell . '</td>';
                     }
                     // New column for the QR button
                     $htmlTable .= '<td "><a  href="qr.php?class_id=' . $row['sch_class'] . '&course_id=' . $row['cor_id'] . '" class="btn btn-primary btn-sm d-flex gap-2 align-items-center">Generate QR</a></td>';
                     $htmlTable .= '<td><a  href="list_attendance.php?class_id=' . $row['sch_class'] . '&course_id=' . $row['cor_id'] . '" class="btn btn-primary btn-sm d-flex gap-2 align-items-center">Attendence</a></td>';
                     // $htmlTable .= '</tr>';
                  }

                  $htmlTable .= '<tfoot><tr>
                 <th colspan=10 style="text-align: center; vertical-align: middle;"><span style="margin-right:60%;" > مجموع الساعات : ' . $shours . ' </span></th>   
                 </tr></tfoot>';
                  $htmlTable .= '</table>';


                  echo "
    <div class='main_content'>
      
        <div class='info'>
          <div>$htmlTable</div>
          
      </div>
    ";

                  ?>


               </div>
            </div>
         </div>
      </div>
   </div>
</div>