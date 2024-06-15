<?php
include 'header.php';


$var = get_curr_smst($year1, $semestar);
$username = (int)filter_var($_SESSION["userid"], FILTER_SANITIZE_NUMBER_INT);
$var2 = get_st_sch($username);

//print_r($var2);
?>

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


            $shours = 0;
            $htmlTable = '<table dir="rtl" id="datatable" class="table table-striped" >';
            $htmlTable .= '<thead><tr><th colspan=11 style="text-align: center; vertical-align: middle;">
   جدول الطالب في ' . $semestar . ' ' . $year1 . '</th></tr>';
            $htmlTable .= '
    <tr>
    <th>رقم المادة </th>
    <th> اسم المادة </th>
    <th> الشعبة </th>
    <th>  س. م</th>
    <th> الايام </th>
    <th> من </th>
    <th> الى </th>
    <th> المدرس</th>
    <th> القاعة</th>
    <th> حالة المادة</th>
    <th> عدد الغيابات</th>
    </tr>
              </thead>';
            foreach ($var2 as $row) {
              $htmlTable .= '<tr>';
              $shours += $row['cor_hours'];
              //var_dump($row);
              foreach ($row as $key => $cell) {
                $dep_count = get_deprived_count($username, $row["cor_id"], $row["sch_class"]);
                $color = "";

                if ($key == "cor_id") {
                  continue;
                }
                if ($key == "sta") {
                  if (!empty($cell)) {
                    $color .= 'style="color:red; font-weight:bold;"';
                  }
                }
                $htmlTable .= '<td ' . $color . '>' . $cell . '</td>';
              }
              $htmlTable .= '<td style="color:blue;text-align:center; font-weight:bold;">' . $dep_count . '</td>';
              $htmlTable .= '</tr>';
            }
            $htmlTable .= '<tfoot><tr>
        <th colspan=11 style="text-align: center; vertical-align: middle;"> مجموع الساعات : ' . $shours . '</th>   
        </tr></tfoot>';
            $htmlTable .= '</table>';

            // Display the HTML table



            echo "
    <div class='main_content'>
      
        <div class='info'>
          <div>$htmlTable</div>
          
      </div>
    ";

            ?>