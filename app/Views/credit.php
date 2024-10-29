<?= $this->extend('pegawai/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <div class="col-3">
        <div class="card">
        <img src="<?= base_url('profile/alok.jpg') ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Afrizal Arnandya Putra | Fullstack</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
        <img src="<?= base_url('profile/1721371470_77f80316dda99b0eb4b2.png') ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Akmal Azahwa | Fullstack</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
        <img src="<?= base_url('profile/marin.gif') ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Muhammad Alban Husein Afferiel | Fullstack</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
        <img src="<?= base_url('profile/1724917252_701ab858e639673e2dab.jpeg') ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Khanif Rokhawi | Fullstack</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
</div>
    
<?= $this->endSection(); ?>