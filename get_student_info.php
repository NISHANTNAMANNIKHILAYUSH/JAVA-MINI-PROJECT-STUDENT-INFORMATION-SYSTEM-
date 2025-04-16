<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "student_info_system";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) die("Connection failed");

// Fetch student_id from POST request
$student_id = $_POST['student_id'];

// Fetch student basic info
$sql = "SELECT * FROM students WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo "===== Student Information =====\n";
    echo "ID: " . $row['student_id'] . "\n";
    echo "Name: " . $row['name'] . "\n";
    echo "DOB: " . $row['dob'] . "\n";
    echo "Email: " . $row['email'] . "\n";
    echo "Course: " . $row['course'] . "\n\n";

    // Fetch academic records
    echo "===== Academic Records =====\n";
    $grade_sql = "SELECT * FROM academic_records WHERE student_id = ?";
    $grade_stmt = $conn->prepare($grade_sql);
    $grade_stmt->bind_param("i", $student_id);
    $grade_stmt->execute();
    $grade_result = $grade_stmt->get_result();

    if ($grade_result->num_rows > 0) {
        while ($grade = $grade_result->fetch_assoc()) {
            echo "Subject: " . $grade['subject'] . " | Grade: " . $grade['grade'] . " | Semester: " . $grade['semester'] . "\n";
        }
    } else {
        echo "No academic records found.\n";
    }

    $grade_stmt->close();

    // Fetch fee records
    echo "\n===== Fee Records =====\n";
    $fee_sql = "SELECT * FROM fees WHERE student_id = ?";
    $fee_stmt = $conn->prepare($fee_sql);
    $fee_stmt->bind_param("i", $student_id);
    $fee_stmt->execute();
    $fee_result = $fee_stmt->get_result();

    if ($fee_result->num_rows > 0) {
        while ($fee = $fee_result->fetch_assoc()) {
            echo "Amount: " . $fee['amount'] . " | Due Date: " . $fee['due_date'] . "\n";
        }
    } else {
        echo "No fee records found.\n";
    }

    $fee_stmt->close();

} else {
    echo "Student not found.";
}

$stmt->close();
$conn->close();
?>
