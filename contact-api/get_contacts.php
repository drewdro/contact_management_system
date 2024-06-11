<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include 'db.php';

$sql = "SELECT * FROM contacts";
$result = $conn->query($sql);

$contacts = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $contacts[] = $row;
    }
} else {
    echo json_encode(["message" => "No contacts found."]);
    exit;
}
echo json_encode($contacts);
$conn->close();
?>
