<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include 'db.php';

// Retrieve the posted data
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $name = $data['name'];
    $age = $data['age'];
    $address = $data['address'];
    $email = $data['email'];

    $sql = "INSERT INTO contacts (name, age, address, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $name, $age, $address, $email);

    $response = [];
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['id'] = $conn->insert_id;
    } else {
        $response['success'] = false;
        $response['message'] = $stmt->error;
    }
} else {
    $response['success'] = false;
    $response['message'] = "No data received";
}

echo json_encode($response);

$stmt->close();
$conn->close();
?>
