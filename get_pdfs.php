<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "root", "pdf_database");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed"]));
}

$category = $_GET["category"] ?? "";
$year = $_GET["year"] ?? "";

if (empty($category) || empty($year)) {
    die(json_encode(["error" => "Missing parameters"]));
}

// Fetch PDFs grouped by subcat1 and subcat2
$sql = "SELECT subcat1, subcat2, filename, filepath FROM pdf_files 
        WHERE category=? AND year=? 
        ORDER BY subcat1, sortid ASC, subcat2, filename";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $category, $year);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[$row["subcat1"]][$row["subcat2"]][] = [
        "filename" => $row["filename"],
        "filepath" => $row["filepath"]
    ];
}

echo json_encode($data);
$conn->close();
?>