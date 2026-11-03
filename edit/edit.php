<?php

// Mengambil data dari formulir
$id = $_POST['id'] ?? '';

$ogc_fid = $_POST['ogc_fid'] ?? '';
$no = $_POST['no'] ?? '';
$biopori = trim($_POST['biopori'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$jumlah = $_POST['jumlah'] ?? '';
$longitude = $_POST['longitude'] ?? '';
$latitude = $_POST['latitude'] ?? '';

// Memeriksa kelengkapan data
if (
    !ctype_digit((string)$id) ||
    (int)$id < 1 ||
    $ogc_fid === '' ||
    $no === '' ||
    $biopori === '' ||
    $alamat === '' ||
    $jumlah === '' ||
    $longitude === '' ||
    $latitude === ''
) {
    die("Semua kolom harus diisi dengan benar.");
}

// Memeriksa tipe data bilangan bulat
if (
    !ctype_digit((string)$ogc_fid) ||
    !ctype_digit((string)$no) ||
    !ctype_digit((string)$jumlah)
) {
    die("OGC FID, nomor, dan jumlah harus berupa bilangan bulat.");
}

// Memeriksa koordinat dan jumlah
if (
    !is_numeric($longitude) ||
    !is_numeric($latitude) ||
    (int)$jumlah < 0 ||
    (float)$longitude < -180 ||
    (float)$longitude > 180 ||
    (float)$latitude < -90 ||
    (float)$latitude > 90
) {
    die("Periksa kembali jumlah dan koordinat.");
}

// Mengubah data numerik
$id = (int)$id;
$ogc_fid = (int)$ogc_fid;
$no = (int)$no;
$jumlah = (int)$jumlah;
$longitude = (float)$longitude;
$latitude = (float)$latitude;

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

// Menyiapkan perintah UPDATE
$stmt = $conn->prepare(
    "UPDATE biopori SET
        ogc_fid = ?,
        `no` = ?,
        biopori = ?,
        alamat = ?,
        jumlah = ?,
        longitude = ?,
        latitude = ?
     WHERE id = ?"
);

if (!$stmt) {
    die("Gagal menyiapkan perintah: " . $conn->error);
}

// Menghubungkan parameter
$stmt->bind_param(
    "iissiddi",
    $ogc_fid,
    $no,
    $biopori,
    $alamat,
    $jumlah,
    $longitude,
    $latitude,
    $id
);

// Menjalankan pembaruan data
if ($stmt->execute()) {

    $stmt->close();
    $conn->close();

    // Kembali ke halaman utama
    header("Location: ../index.php");
    exit;

} else {

    $error = $stmt->error;

    $stmt->close();
    $conn->close();

    die("Data gagal diperbarui: " . $error);
}

?>