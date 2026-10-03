<?php
// Mengembalikan data tempat wisata dalam format JSON untuk dipakai Leaflet
header('Content-Type: application/json; charset=utf-8');
require 'koneksi.php';

$sql = "SELECT w.nama, w.kategori, w.deskripsi, w.latitude, w.longitude,
               k.nama AS kecamatan
        FROM wisata w
        JOIN kecamatan k ON k.id = w.kecamatan_id
        ORDER BY w.nama";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'nama'      => $row['nama'],
        'kategori'  => $row['kategori'],
        'kecamatan' => $row['kecamatan'],
        'deskripsi' => $row['deskripsi'],
        'lat'       => (float) $row['latitude'],
        'lng'       => (float) $row['longitude'],
    ];
}

echo json_encode($data);
$conn->close();
