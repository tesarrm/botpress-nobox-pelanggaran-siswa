<?php
include 'nobox.php';


function generateToken()
{
    // Your PHP function code here
    $username = $_GET['username'];
    $password = $_GET['password'];
    $nobox = new Nobox(null);
    $tokenResponse = $nobox->generateToken($username, $password);

    // echo json_encode($tokenResponse->Data);
    return $tokenResponse->Data;
}

// generateToken();

$token = generateToken();

header("Content-Type:application/json");
$conn = mysqli_connect('localhost', 'root', '', 'botpress-nobox-pelanggaran-siswa');
mysqli_set_charset($conn, 'utf8');
$method = $_SERVER['REQUEST_METHOD'];


$sql = "INSERT INTO token (token) VALUES ('$token')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array('message' => 'Login berhasil', 'token' => $token));
} else {
    echo json_encode(array('message' => 'Error: ' . $conn->error));
}
