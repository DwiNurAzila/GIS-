// Fitur tempat wisata Jember.
// Asumsi: variabel peta Leaflet bernama `map` dan sudah dibuat sebelum file ini dimuat.
// Cara pakai: tambahkan <script src="wisata.js"></script> SETELAH kode pembuatan `map`.

(function () {
  // Cegah karakter HTML dari database merusak popup
  function esc(teks) {
    const d = document.createElement('div');
    d.textContent = teks == null ? '' : teks;
    return d.innerHTML;
  }

  const warnaKategori = {
    'Pantai': '#0288d1',
    'Air Terjun': '#00897b',
    'Wisata Alam': '#43a047'
  };

  function buatIcon(kategori) {
    const warna = warnaKategori[kategori] || '#e53935';
    return L.divIcon({
      className: '',
      html: '<div style="width:18px;height:18px;border-radius:50%;background:' + warna +
            ';border:3px solid #fff;box-shadow:0 0 4px rgba(0,0,0,.5)"></div>',
      iconSize: [18, 18],
      iconAnchor: [9, 9],
      popupAnchor: [0, -10]
    });
  }

  const layerWisata = L.layerGroup().addTo(map);

  fetch('wisata.php')
    .then(function (res) { return res.json(); })
    .then(function (data) {
      data.forEach(function (w) {
        L.marker([w.lat, w.lng], { icon: buatIcon(w.kategori) })
          .bindPopup(
            '<b>' + esc(w.nama) + '</b><br>' +
            '<i>' + esc(w.kategori) + ' - Kec. ' + esc(w.kecamatan) + '</i><br>' +
            esc(w.deskripsi)
          )
          .addTo(layerWisata);
      });
    })
    .catch(function (err) { console.error('Gagal memuat data wisata:', err); });

  // Tombol untuk menampilkan/menyembunyikan layer wisata
  L.control.layers(null, { 'Tempat Wisata': layerWisata }, { collapsed: false }).addTo(map);
})();
