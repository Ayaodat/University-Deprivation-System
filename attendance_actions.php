<?php
// Include database connection file
include 'datastore.php';

// Connect to the database
$conn = connect();

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the record ID is set
if (isset($_POST['record_id'])) {
    // Get the record ID
    $record_id = $_POST['record_id'];

    // Prepare a delete query
    $query = "DELETE FROM attendance WHERE id = ?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "i", $record_id);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // If no record ID is set, display an error message
    echo "No record ID specified";
}

// Close database connection
mysqli_close($conn);
