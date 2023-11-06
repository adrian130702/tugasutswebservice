<?php

include "koneksi.php";

// Menentukan metode request
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

switch($method) {
    case 'GET':
        $sql = "SELECT * FROM destinasi";
        $stmt = $pdo->query($sql);
        $destinasi = $stmt->fetchAll();
        echo json_encode($destinasi);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->alamat_destinasi) && isset($data->tarif) && isset($data->jenis_destinasi)) {
            $sql = "INSERT INTO destinasi (alamat_destinasi, tarif, jenis_destinasi) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->alamat_destinasi, $data->tarif, $data->jenis_destinasi]);
            echo json_encode(['message' => 'Destinasi berhasil ditambahkan']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->nama_destinasi) && isset($data->alamat_destinasi) && isset($data->tarif) && isset($data->jenis_destinasi)) {
            $sql = "UPDATE destinasi SET alamat_destinasi=?, tarif=?, jenis_kelamin=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->alamat_destinasi, $data->tarif, $data->jenis_destinasi, $data->nama_destinasi]);
            echo json_encode(['message' => 'Destinasi berhasil diperbarui']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->nama_destinasi)) {
            $sql = "DELETE FROM destinasi WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->nama_destinasi]);
            echo json_encode(['message' => 'Destinasi berhasil dihapus']);
        } else {
            echo json_encode(['message' => 'ID tidak ditemukan']);
        }
        break;

    default:
        echo json_encode(['message' => 'Metode tidak dikenali']);
        break;
}

?>