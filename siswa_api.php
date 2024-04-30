<?php
header("Content-Type:application/json");
$conn = mysqli_connect('localhost', 'root', '', 'botpress-nobox-pelanggaran-siswa');
mysqli_set_charset($conn, 'utf8');
$method = $_SERVER['REQUEST_METHOD'];
$results = array();

if ($method == 'GET') {
	$query = mysqli_query($conn, 'SELECT * FROM siswa');

	if (mysqli_num_rows($query) > 0) {

		while ($row = $query->fetch_assoc()) {
			$siswa[] = $row;
		}
		echo json_encode($siswa);
	} else {
		$results['Status']['code'] = 400;
		$results['Status']['description'] = 'Request Invalid';
	}
} elseif ($method == 'POST') {

	$nis = $_POST['nis'];
	$nama = $_POST['nama'];
	$kelas = $_POST['kelas'];
	$hportu = $_POST['hportu'];

	$sql = "INSERT INTO siswa (nis, nama, kelas, hportu) VALUES ('$nis', '$nama', '$kelas', '$hportu')";

	if ($conn->query($sql) === TRUE) {
		echo json_encode(array('message' => 'Siswa berhasil ditambahkan'));
	} else {
		echo json_encode(array('message' => 'Error: ' . $conn->error));
	}
} elseif ($method == 'PUT') {
	parse_str(file_get_contents('php://input'), $_PUT);
	$id = $_PUT['id'];
	$nis = $_PUT['nis'];
	$nama = $_PUT['nama'];
	$kelas = $_PUT['kelas'];
	$hportu = $_PUT['hportu'];

	// $sql = "INSERT INTO siswa (nis, nama, kelas, hportu) VALUES ('$nis', '$nama', '$kelas', '$hportu')";
	$sql = "UPDATE siswa SET nis= '$nis', nama= '$nama', hportu= '$hportu' WHERE id='$id'";

	if ($conn->query($sql) === TRUE) {
		echo json_encode(array('message' => 'Siswa berhasil diedit'));
	} else {
		echo json_encode(array('message' => 'Error: ' . $conn->error));
	}
} elseif ($method == 'DELETE') {
	parse_str(file_get_contents('php://input'), $_DELETE);
	$id = $_DELETE['id'];

	$sql = "DELETE FROM siswa WHERE id ='$id'";
	$conn->query($sql);

	$results['Status']['success'] = true;
	$results['Status']['code'] = 200;
	$results['Status']['description'] = 'Data berhasil dihapus';
} else {
	$results['Status']['code'] = 404;
}

//Menampilkan Data JSON dari Database
$json = json_encode($results);
print_r($json);
