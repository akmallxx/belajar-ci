<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
    <h1 class="mb-4">API Documentation - Lokasi Presensi</h1>

    <h2>Base URL</h2>
    <p><code><?= base_url() ?></code></p>

    <h2>Endpoints</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">GET /api/lokasi_presensi</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Retrieve all locations for attendance.</p>
            <h5>Example Request:</h5>
            <pre><code>GET <?= base_url('api/lokasi_presensi') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>[
    {
        "id": 1,
        "nama_lokasi": "Kantor Utama",
        "alamat_lokasi": "Jl. Contoh No.1",
        "tipe_lokasi": "Kantor",
        "latitude": "-6.1751",
        "longitude": "106.8650",
        "radius": 100,
        "zona_waktu": "Asia/Jakarta",
        "jam_masuk": "08:00:00",
        "jam_pulang": "17:00:00"
    },
    ...
]</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">GET /api/lokasi_presensi/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Retrieve a specific location for attendance by ID.</p>
            <h5>Example Request:</h5>
            <pre><code>GET <?= base_url('api/lokasi_presensi/1') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "id": 1,
    "nama_lokasi": "Kantor Utama",
    "alamat_lokasi": "Jl. Contoh No.1",
    "tipe_lokasi": "Kantor",
    "latitude": "-6.1751",
    "longitude": "106.8650",
    "radius": 100,
    "zona_waktu": "Asia/Jakarta",
    "jam_masuk": "08:00:00",
    "jam_pulang": "17:00:00"
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">POST /api/lokasi_presensi</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Create a new location for attendance.</p>
            <h6>Body Parameters:</h6>
            <ul>
                <li><strong>nama_lokasi</strong> (string, required): Name of the location.</li>
                <li><strong>alamat_lokasi</strong> (string, required): Address of the location.</li>
                <li><strong>tipe_lokasi</strong> (string, required): Type of the location.</li>
                <li><strong>latitude</strong> (string, required): Latitude of the location.</li>
                <li><strong>longitude</strong> (string, required): Longitude of the location.</li>
                <li><strong>radius</strong> (integer, required): Radius for attendance.</li>
                <li><strong>zona_waktu</strong> (string, required): Time zone of the location.</li>
                <li><strong>jam_masuk</strong> (string, required): Entry time (format: HH:MM:SS).</li>
                <li><strong>jam_pulang</strong> (string, required): Exit time (format: HH:MM:SS).</li>
            </ul>
            <h5>Example Request:</h5>
            <pre><code>POST <?= base_url('api/lokasi_presensi') ?>
            
Content-Type: application/json

{
    "nama_lokasi": "Kantor Utama",
    "alamat_lokasi": "Jl. Contoh No.1",
    "tipe_lokasi": "Kantor",
    "latitude": "-6.1751",
    "longitude": "106.8650",
    "radius": 100,
    "zona_waktu": "Asia/Jakarta",
    "jam_masuk": "08:00:00",
    "jam_pulang": "17:00:00"
}</code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "message": "Data lokasi presensi berhasil disimpan"
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">PUT /api/lokasi_presensi/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Update an existing location for attendance.</p>
            <h6>Body Parameters:</h6>
            <ul>
                <li><strong>nama_lokasi</strong> (string, optional): Name of the location.</li>
                <li><strong>alamat_lokasi</strong> (string, optional): Address of the location.</li>
                <li><strong>tipe_lokasi</strong> (string, optional): Type of the location.</li>
                <li><strong>latitude</strong> (string, optional): Latitude of the location.</li>
                <li><strong>longitude</strong> (string, optional): Longitude of the location.</li>
                <li><strong>radius</strong> (integer, optional): Radius for attendance.</li>
                <li><strong>zona_waktu</strong> (string, optional): Time zone of the location.</li>
                <li><strong>jam_masuk</strong> (string, optional): Entry time (format: HH:MM:SS).</li>
                <li><strong>jam_pulang</strong> (string, optional): Exit time (format: HH:MM:SS).</li>
            </ul>
            <h5>Example Request:</h5>
            <pre><code>PUT <?= base_url('api/lokasi_presensi/1') ?>
            
Content-Type: application/json

{
    "nama_lokasi": "Kantor Pusat",
    "jam_masuk": "09:00:00"
}</code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "message": "Data lokasi presensi berhasil diubah"
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">DELETE /api/lokasi_presensi/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Delete a specific location for attendance by ID.</p>
            <h5>Example Request:</h5>
            <pre><code>DELETE <?= base_url('api/lokasi_presensi/1') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "message": "Data lokasi presensi berhasil dihapus"
}</code></pre>
        </div>
    </div>

    <h2>Authentication</h2>
    <p>API requests must include a valid API key in the header:</p>
    <pre><code>X-API-Key: your_api_key_here</code></pre>
</div>

<?= $this->endSection(); ?>