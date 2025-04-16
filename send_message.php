<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "student_info_system";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) die("Connection failed");

$title = $_POST['title'];
$message = $_POST['message'];

$sql = "INSERT INTO announcements (title, message, date_posted) VALUES (?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $title, $message);
if ($stmt->execute()) {
    echo "Announcement added.";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>