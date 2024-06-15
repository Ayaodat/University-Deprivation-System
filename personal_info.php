<?php
include 'header.php'; 

//print_r($var2);
$arr = get_user_info($_SESSION['userid']);
              $info = extract($arr[0], EXTR_PREFIX_SAME, "wddx");
              //userid, userpass, username, role, userdept, uercol, personname
              
              if ($role==1)
              {$desc = 'طالب'.' / '.$deg_name;}
              if ($role==2)
              {$desc = 'مدرس';}
              if ($role==3 or $role==4)
              {$desc = $username;}
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
      <link rel="stylesheet" href="./assets/css/dark.min.css"/>
      
      <!-- Customizer Css -->
      <link rel="stylesheet" href="./assets/css/customizer.min.css" />
      
      <!-- RTL Css -->
      <link rel="stylesheet" href="./assets/css/rtl.min.css"/>
      </head>

<div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-sm-12">
         <div class="card" style="width:70% ; margin-left: 15%;">
            <div class="card-header d-flex justify-content-between">
           
            </div>
            <div class="card-body">
              
               <div class="table-responsive">
               <?php


$htmlTable = '<table  dir="rtl" id="datatable" class="table table-striped" style="width=50% !important">';
$htmlTable .=" <thead><tr><th colspan=2 style='text-align: center;  font-weight:bold ;vertical-align: middle;'>
المعلومات الشخصية 
    </th></tr></thead>
    <tr>
    <td>اسم المستخدم: </td>
    <td>$userid</td>
    </tr>
    <tr>
    <td>الاسم: </td>
    <td>$personname</td>
    </tr>
    <tr>
    <td>القسم الأكاديمي: </td>
    <td>$userdept</td>
    </tr>
    <tr>
    <td>الكلية: </td>
    <td>$usercol</td>
    </tr>
    <tr>
    <td>الصفة: </td>
    <td>$desc</td>
    </tr>
    </table>
";             

// Display the HTML table



echo "
    <div class='main_content'>
      
        <div class='info'>
          <div>$htmlTable</div>
          
      </div>
    ";



/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
