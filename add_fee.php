<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "student_info_system";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) die("Connection failed");

$student_id = $_POST['student_id'];
$amount = $_POST['amount'];
$due_date = $_POST['due_date'];

$sql = "INSERT INTO fees (student_id, amount, due_date, paid) VALUES (?, ?, ?, 0)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ids", $student_id, $amount, $due_date);
if ($stmt->execute()) {
    echo "Fee record added.";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>