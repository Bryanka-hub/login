<?php
// koneksi ke database di sistem A 
$mysqli = new mysqli("localhost", "root", "", "web_service");

// Memeriksa apakah koneksi ke database berhasil
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Memeriksa jika 'username' dan 'password' diset dalam request GET
if (isset($_GET['username']) && isset($_GET['password'])) {
    // membaca username dari GET request 
    $user = $_GET['username'];
    // membaca password dari GET request 
    $pass = $_GET['password'];

    // membaca data password user berdasarkan usernamenya 
    $query = "SELECT password FROM user WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($password);

    // Mengambil hasilnya
    $stmt->fetch();

    // Menutup koneksi ke database
    $stmt->close();
    $mysqli->close();

    if ($pass === $password) {
        $response = "TRUE";
    } else {
        $response = "FALSE";
    }
} else {
    $response = "Missing username or password in GET request";
}

// membuat header dokumen XML 
header('Content-Type: text/xml');
echo "<?xml version='1.0'?>";
// membuat tag data respon pada dokumen XML 
echo "<data>";
echo "<response>" . $response . "</response>";
echo "</data>";
