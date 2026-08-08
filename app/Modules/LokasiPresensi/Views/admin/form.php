<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card h-100 border-0 shadow-sm rounded-4">
            <div class="card-header bg-transparent border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-geo-alt-fill text-primary me-2"></i>Pilih Lokasi pada Peta</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-3" onclick="getCurrentLocation()">
                    <i class="bi bi-crosshair me-1"></i> Lokasi Saya
                </button>
            </div>
            <div class="card-body">
                <div id="map" style="height: 400px; width: 100%; border-radius: 14px; z-index: 1;"></div>
                <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle me-1"></i> Klik peta atau geser pin penanda untuk menyesuaikan Latitude & Longitude secara otomatis.</small>
            </div>
        </div>
    </div>

    <div class="col-lg-5 mb-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form method="post" action="<?= base_url('admin/lokasi_presensi/save/' . ($lokasi_presensi['id'] ?? '')) ?>">
                    <?= csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lokasi</label>
                        <input type="text" class="form-control" name="nama_lokasi" placeholder="Contoh: Kantor Pusat" value="<?= htmlspecialchars($lokasi_presensi['nama_lokasi'] ?? '') ?>" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Lokasi</label>
                        <textarea class="form-control" name="alamat_lokasi" rows="2" placeholder="Alamat lengkap..." required><?= htmlspecialchars($lokasi_presensi['alamat_lokasi'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipe Lokasi</label>
                        <input type="text" class="form-control" name="tipe_lokasi" placeholder="Pusat / Cabang" value="<?= htmlspecialchars($lokasi_presensi['tipe_lokasi'] ?? '') ?>" required />
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" value="<?= htmlspecialchars($lokasi_presensi['latitude'] ?? '-6.200000') ?>" required readOnly />
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" value="<?= htmlspecialchars($lokasi_presensi['longitude'] ?? '106.816666') ?>" required readOnly />
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Radius (Meter)</label>
                            <input type="number" class="form-control" id="radius" name="radius" placeholder="50" value="<?= htmlspecialchars($lokasi_presensi['radius'] ?? '50') ?>" required />
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Zona Waktu</label>
                            <select name="zona_waktu" class="form-select" required>
                                <?php $zw = $lokasi_presensi['zona_waktu'] ?? 'WIB'; ?>
                                <option value="WIB" <?= $zw == 'WIB' ? 'selected' : '' ?>>WIB</option>
                                <option value="WITA" <?= $zw == 'WITA' ? 'selected' : '' ?>>WITA</option>
                                <option value="WIT" <?= $zw == 'WIT' ? 'selected' : '' ?>>WIT</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <label class="form-label fw-bold">Jam Masuk</label>
                            <input type="time" class="form-control" name="jam_masuk" value="<?= htmlspecialchars($lokasi_presensi['jam_masuk'] ?? '08:00') ?>" required />
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Jam Pulang</label>
                            <input type="time" class="form-control" name="jam_pulang" value="<?= htmlspecialchars($lokasi_presensi['jam_pulang'] ?? '17:00') ?>" required />
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">Simpan Lokasi</button>
                    <a href="<?= base_url('admin/lokasi_presensi') ?>" class="btn btn-light text-muted w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const radiusInput = document.getElementById('radius');

        let initLat = parseFloat(latInput.value) || -6.200000;
        let initLng = parseFloat(lngInput.value) || 106.816666;
        let initRadius = parseInt(radiusInput.value) || 50;

        const map = L.map('map').setView([initLat, initLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        let marker = L.marker([initLat, initLng], { draggable: true }).addTo(map);
        let circle = L.circle([initLat, initLng], {
            color: '#4f46e5',
            fillColor: '#6366f1',
            fillOpacity: 0.25,
            radius: initRadius
        }).addTo(map);

        function updatePosition(lat, lng) {
            latInput.value = lat.toFixed(7);
            lngInput.value = lng.toFixed(7);
            marker.setLatLng([lat, lng]);
            circle.setLatLng([lat, lng]);
        }

        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            updatePosition(position.lat, position.lng);
        });

        map.on('click', function(e) {
            updatePosition(e.latlng.lat, e.latlng.lng);
        });

        radiusInput.addEventListener('input', function() {
            const r = parseInt(this.value) || 10;
            circle.setRadius(r);
        });

        window.getCurrentLocation = function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    map.setView([lat, lng], 17);
                    updatePosition(lat, lng);
                }, function() {
                    alert("Gagal mengambil lokasi perangkat anda.");
                });
            } else {
                alert("Browser tidak mendukung geolokasi.");
            }
        };
    });
</script>

<?= $this->endSection(); ?>
