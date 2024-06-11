<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include 'db.php';

// Retrieve the posted data
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $id = $data['id'];
    $name = $data['name'];
    $age = $data['age'];
    $address = $data['address'];
    $email = $data['email'];

    $sql = "UPDATE contacts SET name = ?, age = ?, address = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissi", $name, $age, $address, $email, $id);

    $response = [];
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['message'] = "No changes made or no contact found with the given ID.";
        }
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
