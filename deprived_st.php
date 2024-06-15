<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    function deprive_st( e,x) {
  var myArray = e.split("_");
  var st = myArray[0];
  var cor = myArray[1];
  var cclass = myArray[2];
  var act="INSERT";
if(x==2)
    { act ="DELETE";}
var row = document.getElementById(st);
var cell = row.getElementsByTagName("td")[2]; 
if(x==2)
    {var result = confirm("هل أنت متأكد من الغاء حرمان الطالب: "+cell.textContent+"؟");}
    else{
var result = confirm("هل أنت متأكد من حرمان الطالب: "+cell.textContent+"؟");
    }
  if (result){
      var abs = parseInt(document.getElementById('txt_'+e).value);

      if (abs==0){
          alert("الرجاء ادخال عدد الغيابات!!!");
          return;
      }
        $.ajax({
            url: "do_deprived.php", // URL of the server-side script
            type: "POST", // HTTP method (POST recommended for updating data)
            data: { 
                // Data to be sent to the server (if any)
                student: st,
                corid: cor,
                classid: cclass,
                abscnt: abs,
                action: act
            },
            success: function(response){
                // Code to be executed if the request succeeds
                if (response=1)
                    {
                        
                        document.getElementById(e).disabled = true;
                        document.getElementById('lbl_'+e).textContent ="بانتظار رئيس القسم";
                    }
                console.log("Database updated successfully!"+response);
            },
            error: function(xhr, status, error){
                // Code to be executed if the request fails
                console.error("Error updating database:", error);
            }
         });
  }
}
</script>
<?php
include 'header.php';

$chk = check_period(2);
if($chk ==0)
{
    echo "
    <div class='main_content'>
      
        <div class='info'>
          <div>انتهت فترة الحرمان او لم تبدأ بعد</div>
          
      </div>
    ";

    exit;
}

$cor= $_POST['cor_id'];
$class = $_POST['class_id'];          
$arr = get_students_in_class($cor,$class);


if(empty($arr))
{
    echo "
    <div class='main_content'>
      
        <div class='info'>
          <div>لا يوجد طلاب في هذه الشعبة </div>
          
      </div>
    ";

    exit;
}

$cname_arr = array_unique(array_column($arr, 'cor_name'));
$cregno_arr = array_unique(array_column($arr, 'cor_regID'));
$cclass_arr = array_unique(array_column($arr, 'reg_class'));

$cname= $cname_arr[0];
$cregno = $cregno_arr[0];
$cclass = $cclass_arr[0];



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
         <div class="card">
            <div class="card-header d-flex justify-content-between">
           
            </div>
            <div class="card-body">
              
               <div class="table-responsive">
               <?php

$cnt = 0;
$htmlTable = '<table dir="rtl" id="datatable" class="table table-striped">';
$htmlTable .='<thead><tr><th colspan=8 style="text-align: center; font-weight:bold ; color:black; vertical-align: middle;">';
    $htmlTable .='
    <div style="width:100%;margin:0 auto;text-align: center; vertical-align: middle;">
        رقم المادة:&nbsp'.$cregno.' &nbsp  &nbsp &nbsp
اسم المادة: &nbsp'.$cname.' &nbsp  &nbsp &nbsp
            الشعبة:&nbsp '.$cclass.' 
    </div>
 ';
          
                $htmlTable .='<hr>
       </th></tr>';
$htmlTable .='
    <tr>
    <th>متسلسل</th>
    <th> رقم الطالب</th>
    <th> اسم الطالب</th>
    <th>  القسم</th>
    <th>  حالة المادة</th>
    <th> عدد الغيابات</th>
    <th style="text-align:center"> 
    <i class="icon">
    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path opacity="0.4" d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z" fill="currentColor"></path>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.07996 6.6499V6.6599C7.64896 6.6599 7.29996 7.0099 7.29996 7.4399C7.29996 7.8699 7.64896 8.2199 8.07996 8.2199H11.069C11.5 8.2199 11.85 7.8699 11.85 7.4289C11.85 6.9999 11.5 6.6499 11.069 6.6499H8.07996ZM15.92 12.7399H8.07996C7.64896 12.7399 7.29996 12.3899 7.29996 11.9599C7.29996 11.5299 7.64896 11.1789 8.07996 11.1789H15.92C16.35 11.1789 16.7 11.5299 16.7 11.9599C16.7 12.3899 16.35 12.7399 15.92 12.7399ZM15.92 17.3099H8.07996C7.77996 17.3499 7.48996 17.1999 7.32996 16.9499C7.16996 16.6899 7.16996 16.3599 7.32996 16.1099C7.48996 15.8499 7.77996 15.7099 8.07996 15.7399H15.92C16.319 15.7799 16.62 16.1199 16.62 16.5299C16.62 16.9289 16.319 17.2699 15.92 17.3099Z" fill="currentColor"></path>
    </svg></i></th>
    <th>  ملاحظـــات </th>
   
    </tr>
              </thead>';
foreach ($arr as $row) {
    unset($row["cor_name"]);
    unset($row["cor_regID"]);
    unset($row["reg_class"]);
    unset($row["cor_id"]);
    
    $htmlTable .= '<tr id="'.$row["userid"].'">';
    $cnt+=1;
    $lbl ="";
    $disabled ="";
    $depstatus= get_deprived_status($row["userid"],$cor,$class);
    $dep_count=get_deprived_count($row["userid"],$cor,$class);
    if($depstatus==1){
    $disabled = "disabled";
    $lbl="بانتظار رئيس القسم";
    }
    if($depstatus==2 ){
    $disabled = "disabled";
    $lbl="بانتظار العميد";
    }
    if($depstatus==3){
    $disabled = "disabled";
    $lbl="معتمدة ومرحلة";
    }
    if($depstatus==-2 ){
    $disabled = "disabled";
    $lbl="رفضت من رئيس القسم";
    }
    if($depstatus==-3){
    $disabled = "disabled";
    $lbl="رفضت من العميد";
    }
    $htmlTable .= '<td>' . $cnt . '</td>';
    //var_dump($row);
    foreach ($row as $cell) {
        
        $htmlTable .= '<td>' . $cell . '</td>';
    }
    $htmlTable .='<td><input value='.$dep_count.' type="text" '.$disabled.' size="5" id="txt_'.$row["userid"].'_'.$cor.'_'.$class.
            '" name="cnt_abs" "></input></td>'; 
    
    if($depstatus==1){
        $htmlTable .='<td><button class="btn btn-primary btn-sm d-flex gap-2 align-items-center" type="button" id="'.$row["userid"].'_'.$cor.'_'.$class.
            '" name="dep"  onClick="deprive_st(this.id,2)">الغاء الحرمان</button></td>';
    }
    else{
    $htmlTable .='<td><button type="button" class="btn btn-primary btn-sm d-flex gap-2 align-items-center" id="'.$row["userid"].'_'.$cor.'_'.$class.
            '" name="dep" '.$disabled.' onClick="deprive_st(this.id,1)">حرمان الطالب</button></td>';
    }
    $htmlTable .='<td><label style="display: block; width: 100px;" id="lbl_'.$row["userid"].'_'.$cor.'_'.$class.
            '" name="lbl_'.$row["userid"].'" > '.$lbl.'</label></td>';
    $htmlTable .= '</tr>';
}

$htmlTable .= '</table>';


echo "
    <div class='main_content'>
      
        <div class='info'>
        
          <div>$htmlTable </div>
          
      </div>
    ";


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
