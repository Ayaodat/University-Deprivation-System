<?php include 'header.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    function toggleSuccessDiv() {
        var successDiv = document.getElementById("successDiv");
        successDiv.style.display = (successDiv.style.display === "none") ? "block" : "none";
    }


    function getCheckedCheckboxes() {
        // Select all checked checkboxes within the table
        var checkedCheckboxes = document.querySelectorAll("#mytable input[type='checkbox']:checked");
        var abs = [];

        // Output the checked checkboxes
        checkedCheckboxes.forEach(function(checkbox) {
            var nearestTR = checkbox.closest("tr");
            var cell = nearestTR.id;
            if (checkbox.value == 1) {
                abs.push(1 * cell);
            } else {
                abs.push(-1 * cell);
            }

            console.log("absarr", abs);

        });
        var date = document.getElementById("dat").value;
        var cor = document.getElementById("cor").value;
        var cclass = document.getElementById("class").value;

        var abs2 = abs.join(',');
        console.log("abs2=" + abs2);
        var result = confirm("هل أنت متأكد من حفظ كشف الحضور والغياب؟");

        if (result) {

            $.ajax({
                url: "do_absence.php", // URL of the server-side script
                type: "POST", // HTTP method (POST recommended for updating data)
                data: {
                    // Data to be sent to the server (if any)
                    studentlist: abs2,
                    cor: cor,
                    class: cclass,
                    date: date,
                    act: "INSERT"

                },
                success: function(response) {
                    // Code to be executed if the request succeeds
                    if (response == 1) {
                        alert("تمت عملية الحفظ بنجاح");

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

    function handleCheckboxSelection(clickedCheckboxId) {

        var myArray = clickedCheckboxId.split("_");
        var ch = 'radiog_' + myArray[1];
        var checkboxes = document.getElementsByName(ch);

        // Loop through all checkboxes in the group
        checkboxes.forEach(function(checkbox) {
            // Uncheck all checkboxes except the one that was clicked
            if (checkbox.id !== clickedCheckboxId) {
                checkbox.checked = false;
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        var datePicker = document.getElementById("datepicker");
        //datepicker.valueAsDate = new Date();


        datePicker.addEventListener("change", function() {

            dateSelected();
        });

        // Define your JavaScript function to be called when a date is selected
        function dateSelected() {
            // Retrieve the selected date value from the input field
            //var selectedDate = datePicker.value;
            var selectedDate = datePicker.value;

            // Create a new Date object from the selected date string
            var dateObject = new Date(selectedDate);

            // Get the day of the week (0 for Sunday, 1 for Monday, ...)
            var dayOfWeek = dateObject.getDay();

            // Array to map day of the week to its name
            var days = ['ح', 'ن', 'ث', 'ر', 'م', 'Friday', 'Saturday'];

            // Get the name of the day of the week
            var dayName = days[dayOfWeek];

            // Display the day of the week in the designated container
            //var dayContainer = document.getElementById("dayOfWeek");
            //dayContainer.textContent = "Day of the week: " + dayName;

            // Display an alert with the selected date
            document.getElementById("day").value = dayName;
            document.getElementById("dat").value = selectedDate;


        }
    });


    function showhide(e, d) {
        var arr = d.split(" ");
        var dayName = document.getElementById("day").value;
        //document.querySelectorAll("#mytable input[type='checkbox']:checked");
        var checkboxes = document.querySelectorAll("#mytable input[type='checkbox']");
        for (var i = 0; i < checkboxes.length; i++) {

            checkboxes[i].checked = false;
        }
        if (arr.indexOf(dayName) !== -1) {
            var div = document.getElementById("data");
            getcheck();
            div.style.display = "block";

        } else {
            alert("لا تعطى المحاضرة في هذا اليوم");
            return;
        }

    }




    function getcheck() {
        // Get the table element
        var table = document.getElementById("mytable");

        // Get all rows in the table
        var rows = table.rows;


        var date = document.getElementById("dat").value;
        var cor = document.getElementById("cor").value;
        var cclass = document.getElementById("class").value;

        //************************************************
        $.ajax({
            url: "do_absence.php", // URL of the PHP script
            method: "POST",
            data: {
                // Data to be sent to the server (if any)
                studentlist: "",
                cor: cor,
                class: cclass,
                date: date,
                act: "CHK"

            },
            dataType: 'json', // Expected data type of the response
            // Expected data type of the response
            success: function(response) {
                // Handle the response from the PHP script

                for (var key in response) {
                    if (response.hasOwnProperty(key)) {
                        var stu = response[key][0];
                        document.getElementById("abs_" + stu).checked = false;
                        document.getElementById("mabs_" + stu).checked = false;
                        var exec = response[key][1];
                        console.log(key + ': ' + response[key][0]);
                        console.log(key + ': ' + response[key][1]);
                        var myCheckbox = "";
                        if (exec == 0) {
                            myCheckbox = "abs_" + stu;
                        } else {
                            myCheckbox = "mabs_" + stu;
                        }

                        document.getElementById(myCheckbox).checked = true;
                    }
                }

                // Now you ca][]=response;
                // Now yon use the response (2D array) as needed
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error:', error);
            }
        });
        //***********************************************
    }
</script>

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
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">

                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <?php


                        $cor = $_POST['cor_id'];
                        $class = $_POST['class_id'];
                        $arr = get_students_in_class($cor, $class);
                        $days = $_POST['days'];

                        if (empty($arr)) {
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

                        $cname = $cname_arr[0];
                        $cregno = $cregno_arr[0];
                        $cclass = $cclass_arr[0];


                        $cnt = 0;
                        $htmlTable = '<table id="mytable" dir="rtl" id="datatable" class="table table-striped">';
                        $htmlTable .= '<thead><tr><th colspan=7 style="text-align: center; vertical-align: middle;">';
                        $htmlTable .= '
    <div style="width:100%;text-align: center; vertical-align: middle;">
        رقم المادة:&nbsp' . $cregno . ' &nbsp  &nbsp &nbsp
اسم المادة: &nbsp' . $cname . ' &nbsp  &nbsp &nbsp
            الشعبة:&nbsp ' . $cclass . ' 
                &nbsp  &nbsp &nbsp
    </div>
    
 ';

                        $htmlTable .= '<hr>
       </th></tr>';
                        $htmlTable .= '
    <tr>
    <th>متسلسل</th>
    <th> رقم الطالب</th>
    <th> اسم الطالب</th>
    <th>  القسم</th>
    <th>  حالة المادة</th>
    <th> غائب؟</th>
    <th> غائب بعذر؟</th>
    
   
    </tr>
              </thead>';
                        foreach ($arr as $key => $row) {
                            unset($row["cor_name"]);
                            unset($row["cor_regID"]);
                            unset($row["reg_class"]);
                            unset($row["cor_id"]);

                            if ($key == "cor_id") {
                                continue;
                            }

                            $htmlTable .= '<tr id="' . $row["userid"] . '">';
                            $cnt += 1;
                            $lbl = "";
                            $disabled = "";

                            //$abs = get_st_abs($row["userid"],$row["cor_id"],$cclass,$date);

                            if (!empty($row["sta"])) {
                                $disabled = "disabled";
                            }
                            $htmlTable .= '<td>' . $cnt . '</td>';
                            //var_dump($row);
                            foreach ($row as $cell) {

                                $htmlTable .= '<td>' . $cell . '</td>';
                            }
                            $htmlTable .= '<td><input type="checkbox" value="1" ' . $disabled . ' id="abs_' . $row["userid"] . '" name="radiog_' . $row["userid"] . '" onclick="handleCheckboxSelection(this.id)"></input></td>';
                            $htmlTable .= '<td><input type="checkbox" value="2" ' . $disabled . ' id="mabs_' . $row["userid"] . '" name="radiog_' . $row["userid"] . '" onclick="handleCheckboxSelection(this.id)"></input></td>';
                            $htmlTable .= '</tr>';
                        }
                        $htmlTable .= '<tfoot><tr>
<th colspan=7 style="text-align: center; vertical-align: middle;"> 
&nbsp &nbsp &nbsp &nbsp 
<button class="btn btn-primary" onclick="getCheckedCheckboxes()">حفظ الكشف</button>
</th>   
</tr></tfoot>';

                        $htmlTable .= '</table>';


                        echo "
    <div class='card'>
   
    <div class='card-body'>
    <div class='info'>
    <div style='padding:100;text-align: center; vertical-align: middle;direction: rtl;border:1pt;' class='success' ; id='successDiv'>
    
<label class='form-label' style=' font-weight:bold'> &nbsp &nbsp &nbsp &nbsp &nbsp اختر التاريخ</label>
 &nbsp &nbsp
<input type='date' id='datepicker' class='form-control' style='width:35% ; margin-right:35%'> </input>
<br>
&nbsp
<label class='form-label'> اليوم </label>
<input style='width:35% ; height: 39px;' type='text' id='day' disabled></input> 
<br><br>
التاريخ 
<input style='width:35% ; height: 39px;' type='text' id='dat' disabled></input>
<input type='hidden' id='cor' value='$cor' disabled></input>
<input type='hidden' id='class' value='$cclass' disabled></input>
</br>
</br>
&nbsp &nbsp 
<button type='button' class='btn btn-primary' id='show' onClick='showhide(this.id,\"$days\") ;toggleSuccessDiv();'>عرض قائمة الطلبة</button> 
</div>
<br>
    <div id='data' style='display:none;'>$htmlTable </div>
    
</div>
    </div>
</div>
      
  
    ";


                        /*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
                        ?>