<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    function update_deprive_st(e, x) {

        var myArray = e.split("_");
        var st = myArray[1];
        var cor = myArray[2];
        var cclass = myArray[3];

        var apbtn = 'ap_' + st + '_' + cor + '_' + cclass;
        var rjbtn = 'rj_' + st + '_' + cor + '_' + cclass;
        var lbl = st + '_' + cor + '_' + cclass;

        var row = document.getElementById(st);
        var cell = row.getElementsByTagName("td")[2];
        if (x == 2) {
            var result = confirm("هل أنت متأكد من تأكيد حرمان الطالب: " + cell.textContent + "؟");
        }
        if (x == 3) {
            var result = confirm("هل أنت متأكد من رفض حرمان الطالب: " + cell.textContent + "؟");
        }
        if (result) {

            $.ajax({
                url: "do_deprived.php", // URL of the server-side script
                type: "POST", // HTTP method (POST recommended for updating data)
                data: {
                    // Data to be sent to the server (if any)
                    student: st,
                    corid: cor,
                    classid: cclass,
                    action: "UPDATE",
                    val: x
                },
                success: function(response) {
                    // Code to be executed if the request succeeds
                    if (response = 1) {
                        //alert(response);
                        document.getElementById(apbtn).disabled = true;
                        document.getElementById(rjbtn).disabled = true;
                        if (x == 3) {
                            document.getElementById('lbl_' + lbl).textContent = "تم رفض الطلب";
                        } else {
                            document.getElementById('lbl_' + lbl).textContent = "تم قبول الطلب";
                        }
                    }
                    console.log("Database updated successfully!" + response);
                },
                error: function(xhr, status, error) {
                    // Code to be executed if the request fails
                    console.error("Error updating database:", error);
                }
            });
        }
    }
</script>
<?php
include 'header.php';

$username = (int)filter_var($_SESSION["userid"], FILTER_SANITIZE_NUMBER_INT);
$role = $_SESSION["role"];

$arr = get_deprived_list($username, $role);

if (empty($arr)) {
    echo "
    <div class='main_content'>
      
    <div class='info'>
      <div> <p style='text-align:center'>لا يوجد طلبات حرمان</p></div>
      
  </div>
";
    exit;
} ?>

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
                        $cnt = 0;
                        $htmlTable = '<table dir="rtl" id="datatable" class="table table-striped">';
                        $htmlTable .= '<thead><tr><th colspan=11 style="text-align: center; vertical-align: middle;">';
                        $htmlTable .= '
    <div style="width:100%;margin:0 auto;text-align: center; vertical-align: middle;">
        طلبات الحرمان
    </div>
 ';

                        $htmlTable .= '<hr>
       </th></tr>';
                        $htmlTable .= '
    <tr>
    <th>#</th>
    <th> رقم الطالب</th>
    <th> اسم الطالب</th>
        <th> رقم المادة</th>
    <th> اسم المادة</th>
    <th> الشعبة</th>
    <th> ع. غيابات</th>
    <th> مدرس المادة</th>
    <th> </th>
    <th> </th>
    <th>  ملاحظـــات </th>
   
    </tr>
              </thead>';
                        foreach ($arr as $row) {


                            $htmlTable .= '<tr id="' . $row["userid"] . '">';
                            $cnt += 1;
                            $lbl = "";
                            $disabled = "";
                            $depstatus = get_deprived_status($row["userid"], $row["cor_id"], $row["depv_class"]);

                            if ($depstatus == 2 and $role <= 2) {
                                $disabled = "disabled";
                                $lbl = "بانتظار العميد";
                            }
                            if ($depstatus == 3) {
                                $disabled = "disabled";
                                $lbl = "معتمدة ومرحلة";
                            }

                            $htmlTable .= '<td>' . $cnt . '</td>';
                            //var_dump($row);
                            foreach ($row as $key => $cell) {
                                if ($key == "cor_id") {
                                    continue;
                                }
                                $htmlTable .= '<td>' . $cell . '</td>';
                            }

                            $htmlTable .= '<td><button class="btn btn-primary btn-sm d-flex gap-2 align-items-center" type="button" id="ap_' . $row["userid"] . '_' . $row["cor_id"] . '_' . $row["depv_class"] .
                                '" name="dep" ' . $disabled . ' onClick="update_deprive_st(this.id,2)">تأكيد</button></td>';
                            $htmlTable .= '<td><button class="btn btn-primary btn-sm d-flex gap-2 align-items-center" type="button" id="rj_' . $row["userid"] . '_' . $row["cor_id"] . '_' . $row["depv_class"] .
                                '" name="dep" ' . $disabled . ' onClick="update_deprive_st(this.id,3)">رفض</button></td>';
                            $htmlTable .= '<td><label style="display: block; width: 100px;" id="lbl_' . $row["userid"] . '_' . $row["cor_id"] . '_' . $row["depv_class"] .
                                '" name="lbl_' . $row["userid"] . '" > ' . $lbl . '</label></td>';
                            $htmlTable .= '</tr>';
                        }

                        $htmlTable .= '</table>';



                        echo "
    <div class='main_content'>
      
        <div class='info'>
          <div>
$htmlTable
</div>
          
      </div>
    ";
                        /*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
                        ?>