<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "student_info_system";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) die("Connection failed");

$course = $_POST['course'];
$subject = $_POST['subject'];
$teacher = $_POST['teacher'];
$day = $_POST['day'];
$time = $_POST['time'];

$sql = "INSERT INTO class_schedule (course, subject, teacher, day, time_slot) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $course, $subject, $teacher, $day, $time);
if ($stmt->execute()) {
    echo "Class scheduled.";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>