<?php


// Get the current date and time
$currentDateTime = date('Y-m-d H:i:s');

// Construct the SQL query to delete expired tokens
$sql = "DELETE FROM attendance_tokens WHERE expires_at < '$currentDateTime'";

if (connect()->query($sql) === TRUE) {
    // echo "Expired tokens deleted successfully";
} else {
    echo "Error deleting expired tokens: " . connect()->error;
}

connect()->close();
