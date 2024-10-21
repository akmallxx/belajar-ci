<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
    <h1 class="mb-4">API Documentation - Ketidakhadiran</h1>

    <h2>Base URL</h2>
    <p><code><?= base_url() ?></code></p>

    <h2>Endpoints</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">GET /api/ketidakhadiran</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Retrieve absence records for a specific month and year.</p>
            <h6>Query Parameters:</h6>
            <ul>
                <li><strong>bulan</strong> (integer, optional): Month for which to retrieve records (1-12). Defaults to current month if not provided.</li>
                <li><strong>tahun</strong> (integer, optional): Year for which to retrieve records. Defaults to current year if not provided.</li>
            </ul>
            <h5>Example Request:</h5>
            <pre><code>GET <?= base_url('api/ketidakhadiran?bulan=10&tahun=2024') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>[
    {
        "id": 1,
        "id_pegawai": 123,
        "tanggal_awal": "2024-10-10",
        "tanggal_akhir": "2024-10-12",
        "keterangan": "Sakit",
        "deskripsi": "Tidak bisa masuk kerja karena sakit.",
        "file": "document.pdf",
        "status_pengajuan": "disetujui",
        "nama_pegawai": "Jane Doe"
    }
]</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">GET /api/ketidakhadiran/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Retrieve a specific absence record by ID.</p>
            <h5>Example Request:</h5>
            <pre><code>GET <?= base_url('api/ketidakhadiran/1') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "data": {
        "id": 1,
        "id_pegawai": 123,
        "tanggal_awal": "2024-10-10",
        "tanggal_akhir": "2024-10-12",
        "keterangan": "Sakit",
        "deskripsi": "Tidak bisa masuk kerja karena sakit.",
        "file": "document.pdf",
        "status_pengajuan": "disetujui",
        "nama_pegawai": "Jane Doe"
    }
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">POST /api/ketidakhadiran</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Create a new absence record.</p>
            <h6>Body Parameters:</h6>
            <ul>
                <li><strong>id_pegawai</strong> (integer, required): ID of the employee.</li>
                <li><strong>keterangan</strong> (string, required): Reason for absence.</li>
                <li><strong>tanggal_awal</strong> (string, required): Start date of absence (format: YYYY-MM-DD).</li>
                <li><strong>tanggal_akhir</strong> (string, optional): End date of absence (format: YYYY-MM-DD).</li>
                <li><strong>deskripsi</strong> (string, optional): Additional description.</li>
                <li><strong>file</strong> (file, optional): Supporting document for the absence.</li>
                <li><strong>status_pengajuan</strong> (string, required): Status of the absence request.</li>
            </ul>
            <h5>Example Request:</h5>
            <pre><code>POST <?= base_url('api/ketidakhadiran') ?>
            
Content-Type: application/json

{
    "id_pegawai": 123,
    "keterangan": "Sakit",
    "tanggal_awal": "2024-10-10",
    "tanggal_akhir": "2024-10-12",
    "deskripsi": "Tidak bisa masuk kerja karena sakit.",
    "status_pengajuan": "pending"
}</code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "message": "Data berhasil disimpan"
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">PUT /api/ketidakhadiran/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Update an existing absence record.</p>
            <h6>Body Parameters:</h6>
            <ul>
                <li><strong>keterangan</strong> (string, optional): Reason for absence.</li>
                <li><strong>tanggal_awal</strong> (string, optional): Start date of absence (format: YYYY-MM-DD).</li>
                <li><strong>tanggal_akhir</strong> (string, optional): End date of absence (format: YYYY-MM-DD).</li>
                <li><strong>deskripsi</strong> (string, optional): Additional description.</li>
                <li><strong>file</strong> (file, optional): Supporting document for the absence.</li>
                <li><strong>status_pengajuan</strong> (string, required): Status of the absence request.</li>
            </ul>
            <h5>Example Request:</h5>
            <pre><code>PUT <?= base_url('api/ketidakhadiran/1') ?>
            
Content-Type: application/json

{
    "keterangan": "Izin",
    "status_pengajuan": "disetujui"
}</code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "message": "Data berhasil diperbarui"
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">DELETE /api/ketidakhadiran/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Delete a specific absence record by ID.</p>
            <h5>Example Request:</h5>
            <pre><code>DELETE <?= base_url('api/ketidakhadiran/1') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "message": "Data berhasil dihapus"
}</code></pre>
        </div>
    </div>

    <h2>Authentication</h2>
    <p>API requests must include a valid API key in the header:</p>
    <pre><code>X-API-Key: your_api_key_here</code></pre>
</div>

<?= $this->endSection(); ?>