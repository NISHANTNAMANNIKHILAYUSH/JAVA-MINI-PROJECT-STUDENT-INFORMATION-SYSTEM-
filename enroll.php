<?php
include('db_connection.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);

    // Insert the data into the students table
    $query = "INSERT INTO students (student_id, name, dob, email, course) 
              VALUES ('$student_id', '$name', '$dob', '$email', '$course')";

    if (mysqli_query($conn, $query)) {
        echo "Student enrolled successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);  // Close the connection
?>
