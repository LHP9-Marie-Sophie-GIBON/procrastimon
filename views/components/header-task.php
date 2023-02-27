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
</div>