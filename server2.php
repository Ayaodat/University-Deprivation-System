<?php

$errors = array();

if (isset($_POST['change_pass'])) {

  $password = $_POST["old_pass"];
  $password2 = $_POST["new_pass"];
  $password3 = $_POST["con_new_pass"];

  if (empty($password) or empty($password2) or empty($password3)) {
    array_push($errors, "يجب تعبئة جميع الحقول");
  }

  if (md5($password) != $_SESSION["userpass"]) {
    array_push($errors, "كلمة المرور الحالية غير صحيحة");
  }

  if (md5($password2) != md5($password3)) {
    array_push($errors, "كلمة المرور الجديدة غير متطابقة مع تأكيد كلمة المرور");
  }

  if (count($errors) == 0) {

    $x = change_pass($_SESSION["userid"], $password2, $_SESSION["role"]);

    if ($x == 1) {

      $_SESSION['success'] = "تم تعديل كلمة المرور بنجاح";
      $_SESSION['userpass'] = md5($password2);
      echo '<script>alert("تم تغيير كلمة المرور بنجاح")</script>';
    } else {
      array_push($errors, "حصل خطأ ما");
    }
  }
}
