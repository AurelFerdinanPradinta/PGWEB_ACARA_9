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

// Mengambil ID dari URL
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID data tidak valid.");
}

$id = (int) $_GET['id'];

// Mengambil data berdasarkan ID
$sql = "SELECT * FROM biopori WHERE id = $id";
$result = $conn->query($sql);

// Memeriksa ketersediaan data
if (!$result || $result->num_rows == 0) {
    die("Data biopori tidak ditemukan.");
}

// Mengambil data
$row = $result->fetch_assoc();

// Menutup koneksi
$conn->close();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Biopori</title>
</head>
<body>

    <h2>Form Edit Data Biopori</h2>

    <form action="edit.php"
          onsubmit="return validateForm()"
          method="post">

        <!-- Menyimpan ID data -->
        <input type="hidden"
               name="id"
               value="<?= htmlspecialchars((string)$row['id']) ?>">

        <label for="ogc_fid">OGC FID:</label><br>
        <input type="number"
               id="ogc_fid"
               name="ogc_fid"
               value="<?= htmlspecialchars((string)$row['ogc_fid']) ?>"
               required>
        <br>

        <label for="no">Nomor:</label><br>
        <input type="number"
               id="no"
               name="no"
               value="<?= htmlspecialchars((string)$row['no']) ?>"
               required>
        <br>

        <label for="biopori">Biopori:</label><br>
        <input type="text"
               id="biopori"
               name="biopori"
               value="<?= htmlspecialchars($row['biopori'], ENT_QUOTES, 'UTF-8') ?>"
               required>
        <br>

        <label for="alamat">Alamat:</label><br>
        <input type="text"
               id="alamat"
               name="alamat"
               value="<?= htmlspecialchars($row['alamat'], ENT_QUOTES, 'UTF-8') ?>"
               required>
        <br>

        <label for="jumlah">Jumlah:</label><br>
        <input type="number"
               id="jumlah"
               name="jumlah"
               min="0"
               step="1"
               value="<?= htmlspecialchars((string)$row['jumlah']) ?>"
               required>
        <br>

        <label for="longitude">Longitude:</label><br>
        <input type="number"
               id="longitude"
               name="longitude"
               step="any"
               value="<?= htmlspecialchars((string)$row['longitude']) ?>"
               required>
        <br>

        <label for="latitude">Latitude:</label><br>
        <input type="number"
               id="latitude"
               name="latitude"
               step="any"
               value="<?= htmlspecialchars((string)$row['latitude']) ?>"
               required>
        <br><br>

        <input type="submit" value="Submit">

    </form>

    <p id="informasi"></p>

    <script>
        function validateForm() {

            let ogc_fid = Number(document.getElementById("ogc_fid").value);
            let no = Number(document.getElementById("no").value);
            let jumlah = Number(document.getElementById("jumlah").value);

            let longitude = Number(document.getElementById("longitude").value);
            let latitude = Number(document.getElementById("latitude").value);

            let text = "";

            if (
                !Number.isInteger(ogc_fid) ||
                !Number.isInteger(no) ||
                !Number.isInteger(jumlah) ||
                jumlah < 0
            ) {
                text = "OGC FID, nomor, dan jumlah harus berupa bilangan bulat yang valid.";
            }
            else if (
                !Number.isFinite(longitude) ||
                !Number.isFinite(latitude) ||
                longitude < -180 ||
                longitude > 180 ||
                latitude < -90 ||
                latitude > 90
            ) {
                text = "Koordinat longitude atau latitude tidak valid.";
            }

            if (text !== "") {
                document.getElementById("informasi").innerHTML = text;
                return false;
            }

            return true;
        }
    </script>

</body>
</html>