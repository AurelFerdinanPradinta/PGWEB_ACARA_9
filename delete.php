<?php

// Mengambil ID data dari URL
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID data tidak valid.");
}

$id = (int) $_GET['id'];

// Pengaturan koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BioporiYogya";

// Membuat koneksi
$conn = new mysqli(
    $servername,
    $username,
    $password,
    $dbname
);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menyiapkan perintah penghapusan data
$stmt = $conn->prepare(
    "DELETE FROM biopori WHERE id = ?"
);

if (!$stmt) {
    die("Gagal menyiapkan perintah: " . $conn->error);
}

// Menghubungkan parameter ID
$stmt->bind_param("i", $id);

// Menjalankan penghapusan data
if ($stmt->execute()) {

    $stmt->close();
    $conn->close();

    // Kembali ke halaman utama
    header("Location: index.php");
    exit;

} else {

    $error = $stmt->error;

    $stmt->close();
    $conn->close();

    die("Data gagal dihapus: " . $error);
}

?>