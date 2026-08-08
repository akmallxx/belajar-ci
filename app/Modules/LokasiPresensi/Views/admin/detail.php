<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0 text-dark">Informasi Lokasi Presensi</h5>
            </div>
            <div class="card-body px-4">
                <table class="table table-borderless">
                    <tr>
                        <td class="fw-bold text-muted" style="width: 35%;">Nama Lokasi</td>
                        <td style="width: 5%;">:</td>
                        <td class="fw-semibold text-dark"><?= htmlspecialchars($lokasi_presensi['nama_lokasi']) ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Alamat Lokasi</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($lokasi_presensi['alamat_lokasi']) ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Tipe Lokasi</td>
                        <td>:</td>
                        <td><span class="badge bg-primary"><?= htmlspecialchars($lokasi_presensi['tipe_lokasi']) ?></span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Latitude</td>
                        <td>:</td>
                        <td><code><?= htmlspecialchars($lokasi_presensi['latitude']) ?></code></td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Longitude</td>
                        <td>:</td>
                        <td><code><?= htmlspecialchars($lokasi_presensi['longitude']) ?></code></td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Radius Maksimal</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($lokasi_presensi['radius']) ?> Meter</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Zona Waktu</td>
                        <td>:</td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($lokasi_presensi['zona_waktu']) ?></span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Jam Kerja</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($lokasi_presensi['jam_masuk']) ?> - <?= htmlspecialchars($lokasi_presensi['jam_pulang']) ?></td>
                    </tr>
                </table>
                <a href="<?= base_url('admin/lokasi_presensi') ?>" class="btn btn-outline-secondary rounded-3 mt-3"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-map-fill text-primary me-2"></i>Peta Jangkauan Presensi</h5>
            </div>
            <div class="card-body px-4">
                <div id="map-detail" style="height: 360px; width: 100%; border-radius: 14px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const lat = parseFloat("<?= $lokasi_presensi['latitude'] ?>") || -6.200000;
        const lng = parseFloat("<?= $lokasi_presensi['longitude'] ?>") || 106.816666;
        const radius = parseInt("<?= $lokasi_presensi['radius'] ?>") || 50;

        const map = L.map('map-detail').setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup("<b><?= htmlspecialchars($lokasi_presensi['nama_lokasi']) ?></b><br><?= htmlspecialchars($lokasi_presensi['alamat_lokasi']) ?>")
            .openPopup();

        L.circle([lat, lng], {
            color: '#4f46e5',
            fillColor: '#6366f1',
            fillOpacity: 0.25,
            radius: radius
        }).addTo(map);
    });
</script>

<?= $this->endSection(); ?>