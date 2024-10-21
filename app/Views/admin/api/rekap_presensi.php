<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
    <h1 class="mb-4">API Documentation</h1>

    <h2>Base URL</h2>
    <p><code><?= base_url('api') ?></code></p>

    <h2>Endpoints</h2>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">GET /api/rekap_presensi</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Retrieve daily attendance records.</p>
            <h6>Query Parameters:</h6>
            <ul>
                <li><strong>date</strong> (string, optional): The date for which to retrieve attendance records (format: YYYY-MM-DD). Default will shows all data if not provided.</li>
                <li><strong>api_key</strong> (string, required): Your API key for authentication.</li>
            </ul>
            <h5>Example Request:</h5>
            <pre><code>GET <?= base_url('api/rekap_presensi?date=2024-01-23&api_key=your_api_key_here') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "tanggal": "2024-01-23",
    "rekap_presensi": [
        {
            "id": 1,
            "id_pegawai": 123,
            "tanggal_masuk": "2024-01-23",
            "jam_masuk": "08:00:00",
            "jam_keluar": "17:00:00",
            "nama": "John Doe",
            "status": "Hadir",
            "keterlambatan": "Tepat Waktu",
            "hari": "Selasa",
            "lokpres": {
                "id": 1,
                "nama_lokasi": "Kantor Utama"
            }
        }
    ]
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">POST /api/rekap_presensi</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Create a new daily attendance record.</p>
            <h6>Body Parameters:</h6>
            <ul>
                <li><strong>id_pegawai</strong> (integer, required): ID of the employee.</li>
                <li><strong>tanggal_masuk</strong> (string, required): Date of attendance (format: YYYY-MM-DD).</li>
                <li><strong>jam_masuk</strong> (string, required): Time of arrival (format: HH:MM:SS).</li>
                <li><strong>tanggal_keluar</strong> (string, optional): Date of exit (format: YYYY-MM-DD).</li>
                <li><strong>jam_keluar</strong> (string, optional): Time of exit (format: HH:MM:SS).</li>
                <li><strong>foto_masuk</strong> (string, optional): Base64 encoded photo of arrival.</li>
                <li><strong>foto_keluar</strong> (string, optional): Base64 encoded photo of exit.</li>
            </ul>
            <h5>Example Request:</h5>
            <pre><code>POST <?= base_url('api/rekap_presensi?api_key=your_api_key_here') ?>
            
Content-Type: application/json

{
    "id_pegawai": 123,
    "tanggal_masuk": "2024-01-23",
    "jam_masuk": "08:00:00",
    "tanggal_keluar": "2024-01-23",
    "jam_keluar": "17:00:00",
    "foto_masuk": "data:image/jpeg;base64,...",
    "foto_keluar": "data:image/jpeg;base64,..."
}</code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "message": "Data rekap harian berhasil disimpan"
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">GET /api/rekap_presensi/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Retrieve a specific daily attendance record by ID.</p>
            <h5>Example Request:</h5>
            <pre><code>GET <?= base_url('api/rekap_presensi/1?api_key=your_api_key_here') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "data": {
        "id": 1,
        "id_pegawai": 123,
        "tanggal_masuk": "2024-01-23",
        "jam_masuk": "08:00:00",
        "jam_keluar": "17:00:00",
        "nip": "123456",
        "nama": "John Doe",
        "status": "Hadir",
        "keterlambatan": "Tepat Waktu",
        "hari": "Selasa",
        "lokpres": {
            "id": 1,
            "nama_lokasi": "Kantor Utama"
        }
    }
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">PUT /api/rekap_presensi/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Update an existing daily attendance record.</p>
            <h6>Body Parameters:</h6>
            <ul>
                <li><strong>id_pegawai</strong> (integer, required): ID of the employee.</li>
                <li><strong>jam_masuk</strong> (string, optional): Time of arrival (format: HH:MM:SS).</li>
                <li><strong>jam_keluar</strong> (string, optional): Time of exit (format: HH:MM:SS).</li>
            </ul>
            <h5>Example Request:</h5>
            <pre><code>PUT <?= base_url('api/rekap_presensi/1?api_key=your_api_key_here') ?>
            
Content-Type: application/json

{
    "id_pegawai": 123,
    "jam_masuk": "08:30:00",
    "jam_keluar": "17:30:00"
}</code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "message": "Data rekap harian berhasil diubah"
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">DELETE /api/rekap_presensi/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Delete a specific daily attendance record by ID.</p>
            <h5>Example Request:</h5>
            <pre><code>DELETE <?= base_url('api/rekap_presensi/1?api_key=your_api_key_here') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "message": "Data rekap harian dan file terkait berhasil dihapus"
}</code></pre>
        </div>
    </div>

    
</div>

<?= $this->endSection(); ?>
