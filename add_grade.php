<?php
// Include database connection
include('db_connection.php');

// Get data from POST request
$student_id = $_POST['student_id'];
$subject = $_POST['subject'];
$grade = $_POST['grade'];
$semester = $_POST['semester'];

// Check if student exists in the students table
$checkStudentQuery = "SELECT student_id FROM students WHERE student_id = ?";
$stmt = $conn->prepare($checkStudentQuery);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->store_result();

// If the student doesn't exist, return an error
if ($stmt->num_rows === 0) {
    echo "Error: Student with ID $student_id not found.";
    $stmt->close();
    $conn->close();
    exit;
}

$stmt->close(); // Close the check statement

// If the student exists, proceed with inserting the academic record
$query = "INSERT INTO academic_records (student_id, subject, grade, semester) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("isss", $student_id, $subject, $grade, $semester);

if ($stmt->execute()) {
    echo "Academic record added successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
