<div class="row progressbar">
    <div class="col-3">
        <img src="<?= $sprite->chibi ?>" alt="" class="img-fluid">
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
    <?php if (isset($_GET['history'])) { ?>
        <div class="col">
            <button class="btn btn-outline-light">
                <a href="../controllers/controller-trophies.php"><img src="https://img.icons8.com/ios-filled/40/FFFFFF/laurel-wreath.png" /></a>
            </button>
        </div>
    <?php } else { ?>
        <div class="col">
            <button class="btn btn-outline-light">
                <a href="../controllers/controller-trophies.php?history=<?= $procrastimon->id_users ?>"><img src="https://img.icons8.com/external-vitaliy-gorbachev-fill-vitaly-gorbachev/40/FFFFFF/external-book-back-to-school-vitaliy-gorbachev-fill-vitaly-gorbachev.png" /></a>
            </button>
        </div>

    <?php } ?>
</div>