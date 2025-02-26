<?php
$conn = new mysqli("localhost", "telecomanda", "1324", "pdf_database");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql = "SELECT DISTINCT category FROM pdf_files";
$result = $conn->query($sql);

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
}

echo json_encode($categories);
$conn->close();
?>