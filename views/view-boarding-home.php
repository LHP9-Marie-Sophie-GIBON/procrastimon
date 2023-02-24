<?php include 'components/head.php'; ?>

<body>
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
                    <a href="../controllers/controller-home.php"><img src="https://img.icons8.com/sf-regular-filled/30/FFFFFF/home-page.png" /></a>
                </button>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="row" data-masonry='{"percentPosition": true }'>
                <?php
                $procrastimonList = $procrastimon->getOldProcrastimons();
                foreach ($procrastimonList as $oldprocrastimon) {

                    $sprite = new Sprite();
                    $sprite->id = $oldprocrastimon['id_sprites'];
                    $sprite->getSpriteById();

                ?>
                    <div class="col-3">
                        <div class="card">
                            <img src="<?= $sprite->sprite ?>" class="card-img-top img-fluid" alt="..." data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?= $oldprocrastimon['name'] ?>">
                        </div>
                    </div>
                <?php
                } ?>
            </div>
        </div>

    </main>

    <!-- mise en place du footer -->
    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>