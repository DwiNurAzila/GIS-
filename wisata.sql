-- Tabel tempat wisata Jember (jalankan SETELAH database kecamatan sudah ada)
USE db_jember;
 
DROP TABLE IF EXISTS wisata;
CREATE TABLE wisata (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nama         VARCHAR(100)  NOT NULL,
    kategori     VARCHAR(30)   NOT NULL,            -- Pantai, Air Terjun, Wisata Alam
    kecamatan_id INT           NOT NULL,            -- relasi ke tabel kecamatan
    deskripsi    TEXT,
    latitude     DECIMAL(10,6) NOT NULL,
    longitude    DECIMAL(10,6) NOT NULL,
    FOREIGN KEY (kecamatan_id) REFERENCES kecamatan(id)
) ENGINE=InnoDB;
 
-- PENTING: koordinat di bawah hanya perkiraan. Cek ulang lewat Google Maps
-- (klik kanan pada lokasi -> salin koordinat) sebelum dikumpulkan.
INSERT INTO wisata (nama, kategori, kecamatan_id, deskripsi, latitude, longitude) VALUES
('Pantai Papuma',        'Pantai',      (SELECT id FROM kecamatan WHERE nama='Wuluhan'),    'Pantai dengan tebing karang dan pasir putih di pesisir selatan.',        -8.433600, 113.552200),
('Pantai Watu Ulo',      'Pantai',      (SELECT id FROM kecamatan WHERE nama='Ambulu'),     'Pantai dengan batuan karang memanjang yang dikenal lewat legendanya.',    -8.422200, 113.591900),
('Pantai Payangan',      'Pantai',      (SELECT id FROM kecamatan WHERE nama='Ambulu'),     'Pantai berteluk yang populer dengan sebutan Teluk Love.',                 -8.438000, 113.620000),
('Pantai Pancer Puger',  'Pantai',      (SELECT id FROM kecamatan WHERE nama='Puger'),      'Pantai sekaligus pelabuhan nelayan di pesisir Puger.',                    -8.380000, 113.470000),
('Air Terjun Tancak Kembar', 'Air Terjun', (SELECT id FROM kecamatan WHERE nama='Panti'),   'Dua aliran air terjun berdampingan di lereng utara Jember.',              -8.088000, 113.615000),
('Taman Botani Sukorambi', 'Wisata Alam', (SELECT id FROM kecamatan WHERE nama='Sukorambi'), 'Taman rekreasi dan edukasi dengan area hijau dan wahana keluarga.',     -8.138000, 113.660000),
('Rembangan Hill',       'Wisata Alam', (SELECT id FROM kecamatan WHERE nama='Arjasa'),     'Kawasan perbukitan dengan pemandangan kota dan udara sejuk.',             -8.101000, 113.734000),
('Pantai Bandealit',     'Pantai',      (SELECT id FROM kecamatan WHERE nama='Tempurejo'),  'Pantai di kawasan Taman Nasional Meru Betiri.',                           -8.460000, 113.790000);
