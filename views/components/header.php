<header>
    <div class="row progressbar">
        <div class="col">
            <img src="<?= $sprite->sprite ?>" alt="" class="img-fluid">
        </div>
        <div class="col-7">
            <div>
                <?= $procrastimon->name ?> (lvl <?= $procrastimon->level ?>)
            </div>
            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $procrastimon->hp ?>" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar barPV" style="width: <?= $procrastimon->hp ?>%"></div>
            </div>
            <div class="progress" role="progressbar" aria-label="Info example" aria-valuenow="<?= $procrastimon->exp ?>" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar barPP" style="width: <?= $procrastimon->exp ?>%"></div>
            </div>
        </div>
        <div class="col">
            <button class="btn btn-outline-light">
                <a href="../controllers/controller-boarding-home.php"><img src="https://img.icons8.com/ios-glyphs/30/FFFFFF/house-with-a-garden.png" /></a>
            </button>
        </div>
    </div>
</header>