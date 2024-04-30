
<?php
include 'koneksi.php';

// Mendapatkan data semua siswa
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_siswa') {
echo "TEst";

    $sql = "SELECT * FROM siswa";
    $result = $conn->query($sql);

    $siswa = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $siswa[] = $row;
        }
        echo json_encode($siswa);
    } else {
        echo json_encode(array('message' => 'Tidak ada siswa yang ditemukan'));
    }
}

// Menambahkan data pelanggaran
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_pelanggaran') {

    echo $_POST['idsiswa'];

    if(isset($_POST['idsiswa']) && isset($_POST['pelanggaran'])){
        $idsiswa = $_POST['idsiswa'];
        $pelanggaran = $_POST['pelanggaran'];

        $sql = "INSERT INTO pelanggaran (tgljam, idsiswa, pelanggaran) VALUES (NOW(), '$idsiswa', '$pelanggaran')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array('message' => 'Pelanggaran berhasil ditambahkan'));
        } else {
            echo json_encode(array('message' => 'Error: ' . $conn->error));
        }
    } else {
        echo json_encode(array('message' => 'Parameter tidak lengkap'));
    }
}

$conn->close();
?>
