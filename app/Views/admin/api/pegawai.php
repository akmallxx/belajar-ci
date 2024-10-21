<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
    <h1 class="mb-4">API Documentation: Pegawai</h1>

    <h2>Base URL</h2>
    <p><code><?= base_url('api') ?></code></p>

    <h2>Endpoints</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">GET /api/pegawai</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Retrieve a list of all employees along with their associated usernames.</p>
            <h5>Example Request:</h5>
            <pre><code>GET <?= base_url('api/pegawai?api_key=your_api_key_here') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "data": [
        {
            "id": 1,
            "nip": "PEG-0001",
            "nama": "John Doe",
            "username": "johndoe",
            "role": "Pegawai",
            "lokasi_presensi": "Kantor Utama",
            "foto": "john_doe.jpg"
        },
        ...
    ]
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">GET /api/pegawai/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Retrieve a specific employee by ID.</p>
            <h5>Example Request:</h5>
            <pre><code>GET <?= base_url('api/pegawai/1?api_key=your_api_key_here') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "data": {
        "id": 1,
        "nip": "PEG-0001",
        "nama": "John Doe",
        "username": "johndoe",
        "role": "Pegawai",
        "lokasi_presensi": "Kantor Utama",
        "foto": "john_doe.jpg"
    }
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">POST /api/pegawai</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Create a new employee record.</p>
            <h6>Body Parameters:</h6>
            <ul>
                <li><strong>nama</strong> (string, required): Full name of the employee.</li>
                <li><strong>username</strong> (string, required): Username for login.</li>
                <li><strong>password</strong> (string, required): Password for login.</li>
                <li><strong>jenis_kelamin</strong> (string, required): Gender of the employee.</li>
                <li><strong>alamat</strong> (string, required): Address of the employee.</li>
                <li><strong>no_handphone</strong> (string, required): Phone number of the employee.</li>
                <li><strong>jabatan</strong> (string, required): Job position of the employee.</li>
                <li><strong>lokasi_presensi</strong> (integer, required): ID of the attendance location.</li>
                <li><strong>foto</strong> (file, optional): Profile photo of the employee.</li>
            </ul>
            <h5>Example Request:</h5>
            <pre><code>POST <?= base_url('api/pegawai?api_key=your_api_key_here') ?>
            
Content-Type: application/json

{
    "nama": "John Doe",
    "username": "johndoe",
    "password": "password123",
    "jenis_kelamin": "Laki-Laki",
    "alamat": "Indonesia",
    "no_handphone": "08123456789",
    "jabatan": "IT Support",
    "lokasi_presensi": 1,
    "foto": "john_doe.jpg"
}</code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "message": "Pegawai berhasil ditambahkan."
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">PUT /api/pegawai/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Update an existing employee record.</p>
            <h6>Body Parameters:</h6>
            <ul>
                <li><strong>nama</strong> (string, optional): Full name of the employee.</li>
                <li><strong>username</strong> (string, optional): Username for login.</li>
                <li><strong>password</strong> (string, optional): Password for login.</li>
                <li><strong>jenis_kelamin</strong> (string, optional): Gender of the employee.</li>
                <li><strong>alamat</strong> (string, optional): Address of the employee.</li>
                <li><strong>no_handphone</strong> (string, optional): Phone number of the employee.</li>
                <li><strong>jabatan</strong> (string, optional): Job position of the employee.</li>
                <li><strong>lokasi_presensi</strong> (integer, optional): ID of the attendance location.</li>
                <li><strong>foto</strong> (file, optional): Profile photo of the employee.</li>
            </ul>
            <h5>Example Request:</h5>
            <pre><code>PUT <?= base_url('api/pegawai/1?api_key=your_api_key_here') ?>
            
Content-Type: application/json

{
    "nama": "John Doe Updated",
    "username": "johndoe_updated",
    "password": "newpassword123",
    "jenis_kelamin": "Laki-Laki",
    "alamat": "Indonesia Updated",
    "no_handphone": "08123456789",
    "jabatan": "Senior IT Support",
    "lokasi_presensi": 1
}</code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "message": "Pegawai berhasil diperbarui."
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">DELETE /api/pegawai/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Delete a specific employee record by ID.</p>
            <h5>Example Request:</h5>
            <pre><code>DELETE <?= base_url('api/pegawai/1?api_key=your_api_key_here') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "message": "Pegawai berhasil dihapus."
}</code></pre>
        </div>
    </div>

    
</div>

<?= $this->endSection(); ?>
