<?php
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

// Mengambil seluruh data biopori
$sql = "SELECT * FROM biopori ORDER BY id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Biopori Yogyakarta</title>
</head>
<body>

    <h2>Data Sebaran Lokasi Biopori Kota Yogyakarta</h2>

    <a href="input/index.html">Input Data Biopori</a>

    <br><br>

    <?php
    if ($result && $result->num_rows > 0) {

        echo "<table border='1' cellpadding='5' cellspacing='0'>";

        echo "<tr>
                <th>OGC FID</th>
                <th>No</th>
                <th>Biopori</th>
                <th>Alamat</th>
                <th>Jumlah</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th colspan='2'>Aksi</th>
              </tr>";

        // Menampilkan seluruh data
        while ($row = $result->fetch_assoc()) {

            echo "<tr>";

            echo "<td>" . htmlspecialchars((string)$row["ogc_fid"]) . "</td>";

            echo "<td>" . htmlspecialchars((string)$row["no"]) . "</td>";

            echo "<td>" . htmlspecialchars($row["biopori"]) . "</td>";

            echo "<td>" . htmlspecialchars($row["alamat"]) . "</td>";

            echo "<td>" . htmlspecialchars((string)$row["jumlah"]) . "</td>";

            echo "<td>" . htmlspecialchars((string)$row["longitude"]) . "</td>";

            echo "<td>" . htmlspecialchars((string)$row["latitude"]) . "</td>";

            // Tautan hapus
            echo "<td><a href='delete.php?id=" .
                (int)$row["id"] . "'>hapus</a></td>";

            // Tautan edit
            echo "<td><a href='edit/index.php?id=" .
                (int)$row["id"] . "'>edit</a></td>";

            echo "</tr>";
        }

        echo "</table>";

    } else {

        echo "Belum ada data biopori.";
    }

    $conn->close();
    ?>

</body>
</html>