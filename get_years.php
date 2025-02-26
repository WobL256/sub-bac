<?php
$conn = new mysqli("localhost", "telecomanda", "1324", "pdf_database");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$category = $_GET['category'];
$sql = "SELECT DISTINCT year FROM pdf_files WHERE category='$category' ORDER BY year DESC";
$result = $conn->query($sql);

$years = [];
while ($row = $result->fetch_assoc()) {
    $years[] = $row['year'];
}

echo json_encode($years);
$conn->close();
?>