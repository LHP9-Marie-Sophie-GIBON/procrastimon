<header>
    <div class="row resume">
        
    </div>
    <div class="row progressbar mt-3 pe-2 rounded-end-pill border border-light border-5">
        <div class="col-3 rounded-end-circle bg-light border border-light border-5 p-0 m-0">
            <img src="<?= $sprite->chibi ?>" alt="" class="img-fluid rounded-end-circle imgChibi" >
        </div>
        <div class="col ">
            <div class="text-light fw-bold h5 mt-1 mb-0">
                <?= $procrastimon->name ?> <span class="text-light h6">(lvl <?= $procrastimon->level ?>)</span> 
            </div>
            
            <div class="progress rounded-pill" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $procrastimon->hp ?>" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar barPV" style="width: <?= $procrastimon->hp ?>%"><?= $procrastimon->hp ?>/100</div>
            </div>
            
            <div class="progress rounded-pill" role="progressbar" aria-label="Info example" aria-valuenow="<?= $procrastimon->exp ?>" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar barPP" style="width: <?= $procrastimon->exp ?>%"><?= $procrastimon->exp ?>/100</div>
            </div>
        </div>
        <?php
        $controller = basename($_SERVER['PHP_SELF'], '.php');

        if ($controller === 'controller-goals' || $controller === 'controller-todos') { ?>
            <div class="col-1">
                <button class="btn btn-outline-light rounded-pill p-0" type="button" name="add" data-bs-toggle="modal" data-bs-target="#myModal">
                    <img src="https://img.icons8.com/sf-black/30/FFFFFF/plus-math.png" />
                </button>
            </div>
        <?php } else if ($controller === 'controller-trophies') { ?>
            <?php if (isset($_GET['history']) || isset($_GET['CompletedGoals']) || isset($_GET['CompletedTodos']) || isset($_GET['MissedGoals']) || isset($_GET['MissedTodos'])) { ?>
                <div class="col-1">
                    <button class="btn btn-outline-light rounded-pill p-0">
                        <a href="../controllers/controller-trophies.php"><img src="https://img.icons8.com/ios-filled/30/FFFFFF/laurel-wreath.png" /></a>
                    </button>
                </div>
            <?php } else { ?>
                <div class="col-1">
                    <button class="btn btn-outline-light rounded-pill p-0">
                        <a href="../controllers/controller-trophies.php?history=<?= $procrastimon->id_users ?>"><img src="https://img.icons8.com/ios-glyphs/30/FFFFFF/repository.png"/></a>
                    </button>
                </div>

            <?php } ?>
        <?php } ?>
    </div>
</header>