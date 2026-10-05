<?php

require_once "../koneksi.php";


// ========================================
// CEK ID WISATA
// ========================================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Data wisata tidak ditemukan.");
}

$id = (int) $_GET['id'];


// ========================================
// MENGAMBIL DATA WISATA
// ========================================

$stmt = mysqli_prepare(
    $conn,
    "SELECT
        wisata.id,
        wisata.nama,
        wisata.kategori,
        wisata.deskripsi,
        wisata.alamat,
        wisata.latitude,
        wisata.longitude,
        wisata.gambar,
        wisata.jam_buka,
        wisata.harga_tiket,
        kecamatan.nama AS nama_kecamatan,
        kecamatan.id AS kecamatan_id
     FROM wisata
     INNER JOIN kecamatan
        ON wisata.kecamatan_id = kecamatan.id
     WHERE wisata.id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$wisata = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if (!$wisata) {
    die("Data wisata tidak ditemukan.");
}

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars($wisata['nama']) ?>
    </title>

<link rel="stylesheet" href="style.css">

</head>
<body>
<div class="container">
    <a
        href="index.php?kecamatan=<?= (int) $wisata['kecamatan_id'] ?>"
        class="back"
    >
        ← Kembali ke Wisata
        <?= htmlspecialchars($wisata['nama_kecamatan']) ?>
    </a>
    <div class="card">
        <?php if (
            !empty($wisata['gambar']) &&
            file_exists("../assets/images/" . $wisata['gambar'])
        ): ?>

            <img
                src="../assets/images/<?= htmlspecialchars($wisata['gambar']) ?>"
                alt="<?= htmlspecialchars($wisata['nama']) ?>"
                class="hero-image"
            >

        <?php else: ?>

            <div class="no-image">
                Tidak ada gambar
            </div>

        <?php endif; ?>
        <div class="content">
            <span class="kategori">
                <?= htmlspecialchars($wisata['kategori']) ?>
            </span>


            <h1>
                <?= htmlspecialchars($wisata['nama']) ?>
            </h1>


            <div class="deskripsi">

                <?= nl2br(
                    htmlspecialchars(
                        $wisata['deskripsi'] ?? ''
                    )
                ) ?>

            </div>


            <div class="info">


                <div class="info-item">

                    <div class="label">
                        📍 Kecamatan
                    </div>

                    <?= htmlspecialchars(
                        $wisata['nama_kecamatan']
                    ) ?>

                </div>


                <div class="info-item">

                    <div class="label">
                        🏠 Alamat
                    </div>

                    <?= htmlspecialchars(
                        $wisata['alamat'] ?? '-'
                    ) ?>

                </div>


                <div class="info-item">

                    <div class="label">
                        🕐 Jam Buka
                    </div>

                    <?= htmlspecialchars(
                        $wisata['jam_buka'] ?? '-'
                    ) ?>

                </div>


                <div class="info-item">

                    <div class="label">
                        🎟️ Harga Tiket
                    </div>

                    <?php if (
                        isset($wisata['harga_tiket']) &&
                        $wisata['harga_tiket'] > 0
                    ): ?>

                        Rp <?= number_format(
                            $wisata['harga_tiket'],
                            0,
                            ',',
                            '.'
                        ) ?>

                    <?php else: ?>

                        Gratis

                    <?php endif; ?>

                </div>


            </div>


            <?php if (
                !empty($wisata['latitude']) &&
                !empty($wisata['longitude'])
            ): ?>

                <a
                    href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($wisata['latitude'] . ',' . $wisata['longitude']) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="map-button"
                >
                    📍 Buka Lokasi di Google Maps
                </a>

            <?php endif; ?>


        </div>

    </div>

</div>

</body>

</html>
