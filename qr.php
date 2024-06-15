<?php
require_once 'vendor/autoload.php';
include 'datastore.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// Function to generate a random token
function generateRandomToken($length = 32)
{
    return bin2hex(random_bytes($length / 2));
}

$class_id = $_GET['class_id'];
$cor_id = $_GET['course_id'];
$token = generateRandomToken();
// $qr_data = "http://localhost/phpproject2/test2.php?class_id=" . urlencode($class_id) . "&cor_id=" . $cor_id . "&token=" . $token;
$qr_data = "http://localhost:8080/unideprivation/test2.php?class_id=" . urlencode($class_id) . "&course_id=" . urlencode($cor_id) . "&token=" . $token;


$date = date('Y-m-d H:i:s');
$expiry_time = date('Y-m-d H:i:s', strtotime('+20 seconds')); // Token expiry time
$sql = "INSERT INTO attendance_tokens (course_id,class_id,token, created_at, expires_at) VALUES ('$cor_id','$class_id', '$token', '$date', '$expiry_time')";

if (connect()->query($sql) === TRUE) {

    /*     echo "Token stored successfully";
 */
} else {
    echo "Error storing token: " . connect()->error;
}

connect()->close();

// Create an instance of QROptions and set the desired options
$options = new QROptions([
    'outputType' => 'png',
    'eccLevel' => QRCode::ECC_H,
    'scale' => 5, // Adjust the size here, 10 is the default value
    'imageBase64' => false,
    'moduleValues' => [
        // foreground color
        0 => 0xFF0000FF, // red
        // background color
        1 => 0xFFFFFFFF, // transparent
    ],
]);

// Create an instance of QRCode with the custom options
$qrcode = new QRCode($options);

// Generate the QR code image
$image = $qrcode->render($qr_data);

// Output the QR code image
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR code</title>
</head>

<body>
    <div class="qr"><?php echo '<img id="qrCodeImg"  style=" width:600px ; height=600px ; margin-left: 25% ; margin-top:2%" src="data:image/png;base64,' . base64_encode($image) . '" alt="QR Code" />'; ?></div>
    <script type="text/javascript">
        // Function to reload the page every 15 seconds
        setInterval(function() {
            location.reload();
        }, 15000); // 15 seconds in milliseconds
        function deleteExpiredTokens() {
            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();
            // Specify the request method and URL
            xhr.open("GET", "delete_token.php", true);
            // Send the request
            xhr.send();

        }
        deleteExpiredTokens();
    </script>
</body>

</html>