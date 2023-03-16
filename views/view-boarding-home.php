<?php include 'components/head.php'; ?>

<body>
    <!-- mise en place du Header -->
    <?php include 'components/header-task.php'; ?>

    <main>
        <div class="container">
            <div class="row" data-masonry='{"percentPosition": true }'>
                <?php
                $procrastimonList = $procrastimon->getOldProcrastimons();
                // si $procrastimonList est vide, afficher un message
                if (empty($procrastimonList)) {
                    echo "The boarding-home is empty for now";
                } else {
                    // sinon, afficher les procrastimons
                    foreach ($procrastimonList as $oldprocrastimon) {

                        $sprite = new Sprite();
                        $sprite->id = $oldprocrastimon['id_sprites'];
                        $sprite->getSpriteById();
                ?>
                        <div class="col-2">
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#infoModal<?= $oldprocrastimon['id'] ?>">
                                <img src="<?= $sprite->chibi ?>" class="card-img-top img-fluid" alt="..." data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?= $oldprocrastimon['name'] ?>">
                            </button>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="infoModal<?= $oldprocrastimon['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>


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