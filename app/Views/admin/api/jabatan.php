<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
    <h1 class="mb-4">API Documentation - Jabatan</h1>

    <h2>Base URL</h2>
    <p><code><?= base_url() ?></code></p>

    <h2>Endpoints</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">GET /api/jabatan</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Retrieve all job positions.</p>
            <h5>Example Request:</h5>
            <pre><code>GET <?= base_url('api/jabatan') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>[
    {
        "id": 1,
        "jabatan": "Manager"
    },
    {
        "id": 2,
        "jabatan": "Staff"
    }
]</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">GET /api/jabatan/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Retrieve a specific job position by ID.</p>
            <h5>Example Request:</h5>
            <pre><code>GET <?= base_url('api/jabatan/1') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "id": 1,
    "jabatan": "Manager"
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">POST /api/jabatan</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Create a new job position.</p>
            <h6>Body Parameters:</h6>
            <ul>
                <li><strong>jabatan</strong> (string, required): The name of the job position.</li>
            </ul>
            <h5>Example Request:</h5>
            <pre><code>POST <?= base_url('api/jabatan') ?>

Content-Type: application/json

{
    "jabatan": "Supervisor"
}</code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "message": "Jabatan berhasil ditambahkan."
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">PUT /api/jabatan/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Update an existing job position.</p>
            <h6>Body Parameters:</h6>
            <ul>
                <li><strong>jabatan</strong> (string, required): The new name of the job position.</li>
            </ul>
            <h5>Example Request:</h5>
            <pre><code>PUT <?= base_url('api/jabatan/1') ?>

Content-Type: application/json

{
    "jabatan": "Senior Manager"
}</code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "message": "Jabatan berhasil diperbarui."
}</code></pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">DELETE /api/jabatan/{id}</h5>
        </div>
        <div class="card-body">
            <h5>Request</h5>
            <p>Delete a specific job position by ID.</p>
            <h5>Example Request:</h5>
            <pre><code>DELETE <?= base_url('api/jabatan/1') ?></code></pre>
            <h5>Response:</h5>
            <pre><code>{
    "status": "success",
    "message": "Jabatan berhasil dihapus."
}</code></pre>
        </div>
    </div>

    <h2>Authentication</h2>
    <p>API requests must include a valid API key in the header:</p>
    <pre><code>X-API-Key: your_api_key_here</code></pre>
</div>

<?= $this->endSection(); ?>